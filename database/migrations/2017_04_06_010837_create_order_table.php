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
            $table -> date('date');
            $table -> time('startTime');
            $table -> time('endTime');
            $table -> time('duration');

            $table -> integer('state');
            $table -> string('payNum');

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
