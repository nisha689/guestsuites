<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMyGoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_my_goal', function (Blueprint $table) {
            $table->increments('my_goal_id');
            $table->string('my_rogimon_name')->nullable();
            $table->integer('business_service_id')->unsigned()->nullable();
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
        Schema::dropIfExists('gs_my_goal');
    }
}
