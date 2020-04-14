<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAreaOfPainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_area_of_pain', function (Blueprint $table) {
            $table->increments('area_of_pain_id');
            $table->string('area_of_pain_name')->nullable();
            $table->integer('business_service_id')->unsigned()->nullable();
            $table->integer('type')->comment('1 = Fron, 2 = Back')->nullable();
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
        Schema::dropIfExists('gs_area_of_pain');
    }
}