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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->tinyText('name');
            $table->mediumText('description');
            $table->dateTime('open_time');
            $table->dateTime('close_time');
            $table->time('duration');
            $table->integer('full_mark');
            $table->integer('pass_mark');
            $table->boolean('is_sequential');
            $table->boolean('do_mix');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
