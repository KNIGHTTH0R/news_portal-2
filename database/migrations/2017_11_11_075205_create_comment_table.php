<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('body');
            $table->integer('rate_up')->unsigned()->default(0);
            $table->integer('rate_down')->unsigned()->default(0);
            $table->integer('parent_id')->unsigned()->nullable(true);
            $table->integer('user_id')->unsigned();
            $table->integer('news_id')->unsigned();
            $table->boolean('allowed')->nullable(true);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('news_id')
                ->references('id')
                ->on('news')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('user')
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
        Schema::dropIfExists('comment');
    }
}
