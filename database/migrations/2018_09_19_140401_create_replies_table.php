<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('thread_id');
            $table->text('body');
            $table->unsignedInteger('index')->default(0)->comment('所回复的评论的id索引，如果回复的是帖子，则默认为0');
            $table->unsignedInteger('from_user_id');
            $table->unsignedInteger('to_user_id');
            $table->timestamps();

            $table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade');
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('replies');
    }
}
