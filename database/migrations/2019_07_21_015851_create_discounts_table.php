<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_discounts', function (Blueprint $table) {
            $table->increments('discounts_id');
            $table->date('validity_date')->nullable();
            $table->string('code')->nullable();
            $table->integer('discounts_type')->comment('1 = Percent, 2 = Fixed amount')->nullable();
            $table->decimal('percent',8,2)->nullable();
            $table->decimal('fixed_amount',8,2)->nullable();
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
        Schema::dropIfExists('gs_discounts');
    }
}
