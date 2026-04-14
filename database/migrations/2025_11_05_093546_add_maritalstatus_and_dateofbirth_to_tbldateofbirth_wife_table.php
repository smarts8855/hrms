<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaritalstatusAndDateofbirthToTbldateofbirthWifeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbldateofbirth_wife', function (Blueprint $table) {
            $table->string('maritalstatus')->nullable()->after('homeplace');
            $table->date('dateofbirth')->nullable()->after('maritalstatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbldateofbirth_wife', function (Blueprint $table) {
            $table->dropColumn(['maritalstatus', 'dateofbirth']);
        });
    }
}
