<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToEmployersTable extends Migration
{
    public function up(): void
{
    Schema::table('employers', function (Blueprint $table) {
        $table->enum('status', ['pending','verified','rejected'])
              ->default('pending')
              ->after('password');
    });
}

    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
