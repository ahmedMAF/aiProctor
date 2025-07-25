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
        Schema::create('user_exam', function (Blueprint $table) {
            $table->id();
            $table->decimal('mark');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->json('report');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('exam_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_exam');
    }
};
