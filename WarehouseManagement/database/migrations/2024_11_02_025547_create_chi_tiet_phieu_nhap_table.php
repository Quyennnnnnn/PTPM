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
        Schema::create('chi_tiet_phieu_nhap', function (Blueprint $table) {
            $table->unsignedBigInteger('Ma_Phieu_Nhap');
            $table->unsignedBigInteger('Ma_Nguyen_Lieu');
            $table->integer('So_Luong_Nhap');
            $table->decimal('Gia_Nhap', 15, 2);
            $table->date('Ngay_San_Xuat');
            $table->integer('Thoi_Gian_Bao_Quan');
            $table->foreign('Ma_Phieu_Nhap')->references('Ma_Phieu_Nhap')->on('phieu_nhap')->onDelete('cascade');
            $table->foreign('Ma_Nguyen_Lieu')->references('Ma_Nguyen_Lieu')->on('nguyen_lieu')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_phieu_nhap');
    }
};
