<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToJobsTable extends Migration
{
    public function up()
{
    Schema::table('jobs', function (Blueprint $table) {
        $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    });
}

public function down()
{
    Schema::table('jobs', function (Blueprint $table) {
        $table->dropColumn('status');
    });
}

}
