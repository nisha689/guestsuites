<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerConsentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_customer_consent', function (Blueprint $table) {
            $table->increments('customer_consent_id');
            $table->integer('customer_booked_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('business_id')->unsigned()->nullable();
            $table->integer('consent_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('customer_booked_id')->references('customer_booked_id')->on('gs_customer_booked')->onDelete('cascade');

            $table->foreign('business_id')->references('user_id')->on('gs_users')->onDelete('cascade');

            $table->foreign('customer_id')->references('user_id')->on('gs_users')->onDelete('cascade');

            $table->foreign('consent_id')->references('consent_id')->on('gs_consent')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_customer_consent');
    }
}
