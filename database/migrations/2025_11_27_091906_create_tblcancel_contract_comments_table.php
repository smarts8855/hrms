<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblcancelContractCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tblcancel_contract_comments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('contractID');
            $table->text('comment_description');
            $table->unsignedBigInteger('created_by');
            $table->tinyInteger('status')->default(0);


            $table->timestamps();

            // optional foreign keys:
            // $table->foreign('contractID')->references('id')->on('contracts');
            // $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tblcancel_contract_comments');
    }
}
