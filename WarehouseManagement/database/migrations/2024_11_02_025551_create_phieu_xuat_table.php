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
        Schema::create('phieu_xuat', function (Blueprint $table) {
            $table->bigIncrements('Ma_Phieu_Xuat');
            $table->date('Ngay_Xuat');
            $table->text('Mo_Ta')->nullable();
            $table->decimal('Tong_Tien', 15, 2);
            $table->unsignedBigInteger('Ma_Co_So');
            $table->unsignedBigInteger('ID_user');
            $table->foreign('Ma_Co_So')->references('Ma_Co_So')->on('co_so')->onDelete('cascade');
            $table->foreign('ID_user')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('phieu_xuat');
    }
};
