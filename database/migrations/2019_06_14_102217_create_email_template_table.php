<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_email_template', function (Blueprint $table) {
            $table->increments('email_template_id');
			$table->string('subject',200)->nullable();
            $table->string('entity', 200)->nullable();
            $table->text('template_name')->nullable();
            $table->text('template_content')->nullable();
            $table->text('template_fields')->nullable();
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
        Schema::dropIfExists('gs_email_template');
    }
}
