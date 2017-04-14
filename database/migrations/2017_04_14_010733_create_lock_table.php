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
            $table -> uuid('id');
            $table -> primary('id');
            $table -> string('room_id');
            $table -> string('password_id');
            $table -> string('password', 6);
            $table -> timestamp('permission_begin')->default('0');
            $table -> timestamp('permission_end')->default('0');
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
