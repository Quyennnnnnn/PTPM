<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'Name' => 'Admin',
            'Email' => 'admin1@gmail.com',
            'Password' => Hash::make('password123'), // Mã hóa mật khẩu
            'Dia_Chi' => '123 Example Street',
            'Gioi_Tinh' => 'Nam', // Hoặc 'Nu' hoặc 'Khac'
            'SDT' => '0123456789',
            'Role' => 'Admin', 
        ]);
    }
}
