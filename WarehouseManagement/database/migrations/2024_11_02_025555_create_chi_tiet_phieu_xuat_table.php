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
        Schema::create('chi_tiet_phieu_xuat', function (Blueprint $table) {
            $table->unsignedBigInteger('Ma_Phieu_Xuat');
            $table->unsignedBigInteger('Ma_Nguyen_Lieu');
            $table->integer('So_Luong_Xuat');
            $table->decimal('Gia_Xuat', 15, 2);
            $table->foreign('Ma_Phieu_Xuat')->references('Ma_Phieu_Xuat')->on('phieu_xuat')->onDelete('cascade');
            $table->foreign('Ma_Nguyen_Lieu')->references('Ma_Nguyen_Lieu')->on('nguyen_lieu')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_phieu_xuat');
    }
};
