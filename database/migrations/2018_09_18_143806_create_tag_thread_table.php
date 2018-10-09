<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagThreadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建帖子-标签之多对多关联表
        Schema::create('tag_thread', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('thread_id'); // 帖子id
            $table->unsignedInteger('tag_identity'); // 标签id
            $table->timestamps();

            $table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade'); // 外键，关联帖子id，同步删除
            $table->foreign('tag_identity')->references('identity')->on('tags')->onUpdate('cascade')->onDelete('cascade'); // 外键，关联标签id，同步删除
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
        Schema::dropIfExists('tag_thread');
    }
}
