<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBPKBSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_p_k_b_s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cust_id');
            $table->string('status');
            $table->timestamps();

            $table->foreign('cust_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('b_p_k_b_s');
    }
}
