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
        Schema::table('assigned_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('schedule_Id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assigned_schedules', function (Blueprint $table) {
            $table->integer('schedule_Id')->change();
        });
    }
};
