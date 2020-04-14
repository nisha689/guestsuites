<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_consent', function (Blueprint $table) {
            $table->increments('consent_id');
            $table->integer('business_service_id')->unsigned()->nullable();
            $table->string('consent_name')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('gs_consent');
    }
}
