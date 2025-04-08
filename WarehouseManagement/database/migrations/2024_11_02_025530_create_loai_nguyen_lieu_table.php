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
        Schema::create('loai_nguyen_lieu', function (Blueprint $table) {
            $table->bigIncrements('Ma_Loai_Nguyen_Lieu');
            $table->string('Ten_Loai_Nguyen_Lieu', 100);
            $table->text('Mo_Ta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loai_nguyen_lieu');
    }
};
