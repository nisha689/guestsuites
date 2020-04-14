<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerMySkinTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_customer_my_skin', function (Blueprint $table) {
            $table->increments('customer_my_skin_id');
            $table->integer('customer_booked_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('business_id')->unsigned()->nullable();
            $table->integer('my_skin_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('customer_booked_id')->references('customer_booked_id')->on('gs_customer_booked')->onDelete('cascade');

            $table->foreign('business_id')->references('user_id')->on('gs_users')->onDelete('cascade');

            $table->foreign('customer_id')->references('user_id')->on('gs_users')->onDelete('cascade');

            $table->foreign('my_skin_id')->references('my_skin_id')->on('gs_my_skin')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_customer_my_skin');
    }
}
