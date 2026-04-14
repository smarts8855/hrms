<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffidToDetailsofserviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detailsofservice', function (Blueprint $table) {
            $table->unsignedBigInteger('staffid')->nullable()->after('dosid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detailsofservice', function (Blueprint $table) {
            $table->dropColumn('staffid');
        });
    }
}
