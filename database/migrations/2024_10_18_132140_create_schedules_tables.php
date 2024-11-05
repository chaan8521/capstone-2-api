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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->string('edpCode');
            $table->string('offeringCode');
            $table->integer('subject_Id');
            $table->string('day');
            $table->dateTime('timeIn');
            $table->dateTime('timeOut');
            $table->unsignedBigInteger('user_Id');  
            $table->timestamps();; 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
