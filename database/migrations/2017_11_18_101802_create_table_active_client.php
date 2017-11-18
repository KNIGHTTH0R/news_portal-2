<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableActiveClient extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('active_client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ip');
            $table->string('user_agent');
            $table->string('token')->unique();
            $table->timestamp('last_seen_at');
            $table->integer('news_id')->unsigned();


            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('active_client');
    }
}
