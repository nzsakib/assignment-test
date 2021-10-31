<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class ImportDataIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Imports insert statement to import data from sql file
        DB::unprepared(file_get_contents(storage_path('data-dump.sql')));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Empty the table
        DB::table('users')->truncate();
    }
}
