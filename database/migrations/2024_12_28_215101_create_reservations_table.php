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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('sheet_id');
            $table->string('email');
            $table->string('name');
            $table->boolean('is_canceled')->default(false);
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('sheet_id')->references('id')->on('sheets');
            // 外部キー制約を追加
            $table->unique(['schedule_id', 'sheet_id','date']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
