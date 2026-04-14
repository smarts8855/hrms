<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateSuspendDefaultOnUsersTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE users MODIFY suspend VARCHAR(255) NOT NULL DEFAULT '0'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users MODIFY suspend VARCHAR(255) NULL");
    }
}
