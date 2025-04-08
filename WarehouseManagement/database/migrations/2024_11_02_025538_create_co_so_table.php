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
        Schema::create('co_so', function (Blueprint $table) {
            $table->bigIncrements('Ma_Co_So');
            $table->string('Ten_Co_So', 100);
            $table->text('Mo_Ta')->nullable();
            $table->enum('Trang_Thai', ['Hoat_Dong', 'Ngung_Hoat_Dong']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('co_so');
    }
};
