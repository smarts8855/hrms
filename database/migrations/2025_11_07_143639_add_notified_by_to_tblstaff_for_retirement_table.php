<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotifiedByToTblstaffForRetirementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tblstaff_for_retirement', function (Blueprint $table) {
            $table->string('notifiedBy')->nullable()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tblstaff_for_retirement', function (Blueprint $table) {
            $table->dropColumn('notifiedBy');
        });
    }
}
