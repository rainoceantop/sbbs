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
        // 创建评论表
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('thread_id'); // 所属帖子id
            $table->text('body'); // 评论内容
            $table->unsignedInteger('index')->default(0)->comment('所回复的评论的id索引，如果回复的是帖子，则默认为0'); // 评论索引
            $table->unsignedInteger('from_user_id'); // 评论人id
            $table->unsignedInteger('to_user_id'); // 被评论人id
            $table->timestamps();

            $table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade'); // 外键，关联帖子id，同步删除
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade'); // 外键，关联用户id，同步删除
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade'); // 外键，关联用户id，同步删除
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
