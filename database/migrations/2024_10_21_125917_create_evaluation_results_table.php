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
        Schema::create('evaluation_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assigned_schedule_Id'); 
            $table->foreign('assigned_schedule_Id')->references('Id')->on('assigned_schedules')->onDelete('cascade');
            $table->unsignedBigInteger('question_Id');
            $table->foreign('question_Id')->references('id')->on('questionaires')->onDelete('cascade');
            $table->integer('score');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluation_results');
    }
};
