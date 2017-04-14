<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pageView', function (Blueprint $table)
        {
            $table->integer('home');
            $table->integer('create');
            $table->integer('result');
            $table->integer('comment');
            $table->integer('commentResult');
            $table->integer('orderList');

            $table->timestamp('date');
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
        Schema::dropIfExists('pageView');
    }
}
