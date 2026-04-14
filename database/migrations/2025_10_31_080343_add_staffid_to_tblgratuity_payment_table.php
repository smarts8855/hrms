<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStaffidToTblgratuityPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblgratuity_payment', function (Blueprint $table) {
            $table->unsignedBigInteger('staffid')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblgratuity_payment', function (Blueprint $table) {
            $table->dropColumn('staffid');
        });
    }
}
