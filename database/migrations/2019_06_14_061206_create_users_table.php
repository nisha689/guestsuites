<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gs_users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('company_name')->nullable();
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->integer('gender')->nullable()->comment('1 => Male, 2 => Female');
            
            $table->text('address')->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('state_id')->unsigned()->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->string('zipcode')->nullable();
            $table->string('photo')->nullable();
            $table->dateTime('current_login_date')->nullable();
            $table->dateTime('last_login_date')->nullable();
            $table->string('created_type',100)->nullable()->comment('Web, App');
            $table->string('ip_address',100)->nullable();
            $table->integer('role_id')->unsigned()->nullable();
            $table->integer('business_id')->unsigned()->nullable();
            $table->integer('business_service_id')->unsigned()->nullable();
            $table->integer('plan_id')->unsigned()->nullable();
            $table->integer('status')->comment('1 = Active, 0 = Inactive')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('device_type')->comment('android, ios')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('role_id')->on('gs_roles')->onDelete('cascade');
            $table->foreign('country_id')->references('country_id')->on('gs_country')->onDelete('cascade');
            $table->foreign('state_id')->references('state_id')->on('gs_state')->onDelete('cascade');
            $table->foreign('city_id')->references('city_id')->on('gs_city')->onDelete('cascade');

            $table->foreign('business_service_id')->references('business_service_id')->on('gs_business_services')->onDelete('cascade');
            $table->foreign('plan_id')->references('plan_id')->on('gs_plan')->onDelete('cascade');
            $table->foreign('business_id')->references('user_id')->on('gs_users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gs_users');
    }
}
