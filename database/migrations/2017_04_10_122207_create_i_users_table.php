<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_users', function (Blueprint $table) {

            $table -> uuid('id');
            $table -> primary('id');
            $table->string('openid');
            $table->string('nickname');
            $table->smallInteger('sex');
            $table->string('province');
            $table->string('city');
            $table->string('country');
            $table->string('headimgurl');
            $table->string('privilege');
            $table->string('unionid');
            $table->string('phonenumber', 11)->nullable();
            $table->string('idnumber', 18)->nullable();
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
        Schema::dropIfExists('i_users');
    }
}
