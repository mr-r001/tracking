<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSTNKSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_t_n_k_s', function (Blueprint $table) {
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
        Schema::dropIfExists('s_t_n_k_s');
    }
}
