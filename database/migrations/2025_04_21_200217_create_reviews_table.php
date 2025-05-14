<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
        $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
        $table->tinyInteger('rating')->unsigned();  // Rating out of 5
        $table->text('review')->nullable();  // Review text
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
