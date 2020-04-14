<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_plan', function (Blueprint $table) {
            $table->increments('plan_id');
            $table->string('plan_name')->nullable();
            $table->decimal('price',8,2)->nullable();
            $table->text('description');
            $table->string('created_type')->comment("Web or App")->nullable();
            $table->integer('status')->default(0)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_plan');
    }
}
