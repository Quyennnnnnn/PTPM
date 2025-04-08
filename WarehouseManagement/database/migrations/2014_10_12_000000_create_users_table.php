<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Name', 100);
            $table->string('Email', 100)->unique();
            $table->string('password', 255);
            $table->string('Dia_Chi', 255)->nullable();
            $table->enum('Gioi_Tinh', ['Nam', 'Nu', 'Khac']);
            $table->string('SDT', 15)->nullable();
            $table->enum('Role', ['Admin', 'Nhan_Vien']);
            $table->string('image')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
