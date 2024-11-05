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
        Schema::create('assigned_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_Id'); 
            $table->foreign('user_Id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('schedule_Id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_schedules');
    }
};
