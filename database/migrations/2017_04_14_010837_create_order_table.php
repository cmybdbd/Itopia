<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function(Blueprint $table){
            $table -> uuid('id');
            $table -> primary('id');
            $table -> string('userId');
            $table -> string('roomId');
            $table -> timestamp('date')->nullable();
            $table -> timestamp('startTime')->nullable();
            $table -> timestamp('endTime')->nullable();
            $table -> double('duration');
            $table -> boolean('isDay');
            $table -> integer('state');
            $table -> string('payNum');
            $table -> double('price');
            $table -> string("orderno"); //for quickpass

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
        Schema::dropIfExists('orders');
    }
}
