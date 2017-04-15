<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('locks', function(Blueprint $table){
            $table -> string('id');
            $table -> primary('id');
            $table -> string('room_id');
            $table -> string('password', 6);
            $table -> timestamp('permission_begin')->nullable();
            $table -> timestamp('permission_end')->nullable();
//            $table -> integer('state');
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
        Schema::dropIfExists('locks');
    }
}
