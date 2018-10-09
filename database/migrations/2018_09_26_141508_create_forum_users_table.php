<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建板块-版主之多对多关联表
        Schema::create('forum_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forum_id'); // 板块id
            $table->unsignedInteger('user_id'); // 版主id

            $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade'); // 外键，关联板块id，同步删除
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // 外键，关联版主id，同步删除
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_users');
    }
}
