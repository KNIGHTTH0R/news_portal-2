<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::create('image', function (Blueprint $table) {
//            $table->increments('id');
//            $table->string('path');
//            $table->string('filename');
//            $table->integer('news_id')->unsigned();
//            $table->timestamps();
//
//            $table->foreign('news_id')
//                ->references('id')
//                ->on('news')
//                ->onDelete('cascade')
//                ->onUpdate('cascade');
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image');
    }
}
