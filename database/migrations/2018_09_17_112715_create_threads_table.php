<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建帖子表
        Schema::create('threads', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id'); // 帖子的所属人id
            $table->unsignedInteger('forum_id'); // 所属论坛id
            $table->string('title'); // 标题
            $table->text('body'); // 内容（经过markdown转化后的html代码）
            $table->text('body_md'); // markdown原本内容 
            $table->tinyInteger('is_filed')->default(0); // 是否归档，0：是，1：否
            $table->tinyInteger('is_good')->default(0); // 是否精华，0：是，1：否
            $table->tinyInteger('is_top')->default(0); // 是否置顶，0：是，1：否
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // 外键，关联用户id，同步删除
            $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade'); // 外键，关联板块id，同步删除
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
        Schema::dropIfExists('threads');
    }
}
