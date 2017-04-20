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
            $table -> timestamp('startDate')->nullable();
            $table -> timestamp('startTime')->nullable();
            $table -> timestamp('endTime')->nullable();
            $table -> double('duration');
            $table -> boolean('isDay');
            $table -> integer('state');
            $table -> string('payNum')->nullable();
            $table -> double('price');
            $table -> char('passwd', 6)->nullable();
            $table -> string("orderno")->nullable(); //for quickpass

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
