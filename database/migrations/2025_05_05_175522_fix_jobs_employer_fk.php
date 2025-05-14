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
    Schema::table('jobs', function (Blueprint $table) {
        // First, try adding the FK directly (skip dropping if not sure it exists)
        $table->foreign('employer_id')
              ->references('id')
              ->on('employers')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
   
public function down()
{
    Schema::table('jobs', function (Blueprint $table) {
        // Empty on purpose; the actual statements go outside the closure
    });

    DB::statement('
        SET @fk_name := (
            SELECT CONSTRAINT_NAME 
            FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
            WHERE TABLE_NAME = "jobs" 
              AND COLUMN_NAME = "employer_id" 
              AND CONSTRAINT_SCHEMA = DATABASE()
              AND REFERENCED_TABLE_NAME IS NOT NULL
            LIMIT 1
        );
    ');

    DB::statement('
        SET @sql := IF(@fk_name IS NOT NULL, 
            CONCAT("ALTER TABLE jobs DROP FOREIGN KEY ", @fk_name), 
            "SELECT 1"
        );
    ');

    DB::statement('PREPARE stmt FROM @sql;');
    DB::statement('EXECUTE stmt;');
    DB::statement('DEALLOCATE PREPARE stmt;');
}

};
