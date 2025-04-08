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
        Schema::create('phieu_nhap', function (Blueprint $table) {
            $table->bigIncrements('Ma_Phieu_Nhap');
            $table->date('Ngay_Nhap');
            $table->text('Mo_Ta')->nullable();
            $table->decimal('Tong_Tien', 15, 2);
            $table->unsignedBigInteger('Ma_NCC');
            $table->unsignedBigInteger('ID_user');  
            $table->foreign('Ma_NCC')->references('Ma_nha_cung_cap')->on('nha_cung_cap')->onDelete('cascade');
            $table->foreign('ID_user')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_nhap');
    }
};
