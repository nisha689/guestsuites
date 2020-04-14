<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_message', function (Blueprint $table) {
            $table->increments('message_id');
            $table->integer('sender_id')->unsigned();
            $table->integer('receiver_id')->unsigned();
            $table->text('message')->nullable();
            $table->string('attachment')->nullable();
            $table->integer('status')->nullable()->comment("1 => Unread, 2 => Read");
            $table->timestamps();

            $table->foreign('sender_id')->references('user_id')->on('gs_users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('user_id')->on('gs_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_message');
    }
}
