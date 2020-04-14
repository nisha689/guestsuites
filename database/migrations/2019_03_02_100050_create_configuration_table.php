<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_configuration', function (Blueprint $table) {
            $table->increments('id');
			$table->string('key')->nullable();
			$table->string('value')->nullable();
			$table->string('label')->nullable();
            $table->integer('group_type')->nullable();
            $table->integer('user_id')->default('0');
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
        Schema::dropIfExists('gs_configuration');
    }
}
