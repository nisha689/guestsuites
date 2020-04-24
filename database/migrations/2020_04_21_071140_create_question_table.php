<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_question', function (Blueprint $table) {
            $table->increments('question_id');
            $table->integer('service_category_id')->unsigned()->nullable();
            $table->string('label')->nullable();
            $table->string('type')->nullable();
            $table->string('option')->nullable();
            $table->integer('parent_question_id')->nullable();
            $table->timestamps();

            $table->foreign('service_category_id')->references('service_category_id')->on('gs_service_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_question');
    }
}
