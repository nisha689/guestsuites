<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerBookedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_customer_booked', function (Blueprint $table) {
            $table->increments('customer_booked_id');
            $table->integer('business_id')->unsigned()->nullable();
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('business_service_id')->unsigned()->nullable();
            $table->string('signature_img')->nullable();
            $table->timestamp('start_date_time')->nullable();
            $table->timestamp('finish_date_time')->nullable();
            
            $table->timestamps();

            $table->foreign('business_id')->references('user_id')->on('gs_users')->onDelete('cascade');
            $table->foreign('customer_id')->references('user_id')->on('gs_users')->onDelete('cascade');
            $table->foreign('business_service_id')->references('business_service_id')->on('gs_business_services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_customer_booked');
    }
}
