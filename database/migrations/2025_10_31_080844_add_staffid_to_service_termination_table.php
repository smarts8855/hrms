<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffidToServiceTerminationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('service_termination', function (Blueprint $table) {
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
        Schema::table('service_termination', function (Blueprint $table) {
            $table->dropColumn('staffid');
        });
    }
}
