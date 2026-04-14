<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffidToRecordofServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recordof_service', function (Blueprint $table) {
            $table->unsignedBigInteger('staffid')->nullable()->after('fileNo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recordof_service', function (Blueprint $table) {
            $table->dropColumn('staffid');
        });
    }
}
