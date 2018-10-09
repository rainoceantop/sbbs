<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建标签组表
        Schema::create('tag_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forum_id'); // 所属板块id
            $table->string('name'); // 标签组名称
            $table->timestamps();

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
        Schema::dropIfExists('tag_groups');
    }
}
