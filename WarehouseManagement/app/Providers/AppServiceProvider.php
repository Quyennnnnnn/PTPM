<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Factories\RepositoryFactory;
use App\Factories\MySQLRepositoryFactory;
use App\Factories\RedisRepositoryFactory;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RepositoryFactory::class, function () {
            $driver = config('database.default');
            if ($driver === 'mysql') {
                return new MySQLRepositoryFactory();
            } elseif ($driver === 'redis') {
                return new RedisRepositoryFactory();
            }
            throw new \Exception("Unsupported database driver: {$driver}");
        });
    }

    public function boot()
    {
        //
    }
}
