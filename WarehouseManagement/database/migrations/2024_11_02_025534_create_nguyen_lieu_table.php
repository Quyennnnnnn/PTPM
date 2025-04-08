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
        Schema::create('nguyen_lieu', function (Blueprint $table) {
            $table->bigIncrements('Ma_Nguyen_Lieu'); 
            $table->string('Ten_Nguyen_Lieu', 100);
            $table->text('Mo_Ta')->nullable();
            $table->string('Don_Vi_Tinh', 50);
            $table->string('Barcode', 100)->nullable();
            $table->integer('So_Luong_Ton')->default(0); 
            $table->string('Image')->nullable();
            $table->unsignedBigInteger('Ma_loai_nguyen_lieu');
            $table->foreign('Ma_loai_nguyen_lieu')->references('Ma_loai_nguyen_lieu')->on('loai_nguyen_lieu')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguyen_lieu');
    }
};
