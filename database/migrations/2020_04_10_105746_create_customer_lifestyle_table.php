<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerLifestyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_customer_lifestyle', function (Blueprint $table) {
            $table->increments('customer_lifestyle_id');
            $table->integer('customer_booked_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('business_id')->unsigned()->nullable();
            $table->integer('lifestyle_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('customer_booked_id')->references('customer_booked_id')->on('gs_customer_booked')->onDelete('cascade');

            $table->foreign('business_id')->references('user_id')->on('gs_users')->onDelete('cascade');

            $table->foreign('customer_id')->references('user_id')->on('gs_users')->onDelete('cascade');

            $table->foreign('lifestyle_id')->references('lifestyle_id')->on('gs_lifestyle')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_customer_lifestyle');
    }
}