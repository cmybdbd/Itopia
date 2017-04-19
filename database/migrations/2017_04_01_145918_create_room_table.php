<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function(Blueprint $table){
            $table -> uuid('id');
            $table -> primary('id');
            $table -> string('parentId');
            $table -> text('title');
            $table -> text('address');
            $table -> double('longitude');
            $table -> double('latitude');
            $table -> integer('type');

            $table -> double('hourPrice');
            $table -> double('nightPrice');

            $table -> string('roomLockId');
            $table -> string('passwd')->nullable();
            $table -> integer('phoneOfManager');
            $table -> integer('state');
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
        Schema::dropIfExists('rooms');
    }
}
