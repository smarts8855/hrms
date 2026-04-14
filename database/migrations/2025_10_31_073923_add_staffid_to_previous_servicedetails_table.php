<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffidToPreviousServicedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('previous_servicedetails', function (Blueprint $table) {
            $table->unsignedBigInteger('staffid')->nullable()->after('doppsid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('previous_servicedetails', function (Blueprint $table) {
            $table->dropColumn('staffid');
        });
    }
}
