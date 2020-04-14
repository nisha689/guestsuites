<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_city', function (Blueprint $table) {
            $table->increments('city_id');
            $table->string('city_name')->nullable();
            $table->integer('state_id')->unsigned();

           $table->foreign('state_id')->references('state_id')->on('gs_state')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_city');
    }
}
