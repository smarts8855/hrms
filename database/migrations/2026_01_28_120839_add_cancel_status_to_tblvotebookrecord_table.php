<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelStatusToTblvotebookrecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblvotebookrecord', function (Blueprint $table) {
             $table->integer('cancel_status')->nullable()->after('period');
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblvotebookrecord', function (Blueprint $table) {
            $table->dropColumn('cancel_status');
            //
        });
    }
}
