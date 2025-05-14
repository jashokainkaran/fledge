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
    Schema::table('reviews', function (Blueprint $table) {
        $table->unsignedBigInteger('application_id')->nullable();
        $table->foreign('application_id')->references('id')->on('job_applications');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    
{
    Schema::table('reviews', function (Blueprint $table) {
        $table->dropForeign(['application_id']);
        $table->dropColumn('application_id');
    });
}
};
