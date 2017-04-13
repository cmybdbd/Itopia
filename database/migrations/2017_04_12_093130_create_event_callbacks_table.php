<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventCallbacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_callbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid');
            $table->string('home_id');
            $table->string('room_id')->nullable();
            $table->bigInteger('time');
            $table->string('nickname');
            $table->string('detail');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_callbacks');
    }
}
