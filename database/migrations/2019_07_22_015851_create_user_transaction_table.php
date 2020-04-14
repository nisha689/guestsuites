<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_id')->nullable();
            $table->integer('payment_method')->comment('1 => Stripe, 2 => Paypal');
            $table->decimal('amount',8,2);
            $table->decimal('net_amount',8,2);
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('plan_id')->unsigned()->nullable();
            $table->integer('discounts_id')->unsigned()->nullable();
            $table->string('created_type')->comment("Web or App")->nullable();
            $table->integer('status')->default(0)->comment('1 => Success, 0 => fail');
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('gs_users')->onDelete('cascade');
            $table->foreign('plan_id')->references('plan_id')->on('gs_plan')->onDelete('cascade');
            $table->foreign('discounts_id')->references('discounts_id')->on('gs_discounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_transaction');
    }
}
