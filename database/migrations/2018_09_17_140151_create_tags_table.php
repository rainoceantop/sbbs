<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建标签表
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('forum_id'); // 所属板块id
            $table->unsignedInteger('tag_group_id'); // 所属标签组id
            $table->unsignedInteger('identity')->unique(); // （主键，在model已设置）标签的唯一标识
            $table->string('name'); // 标签名称
            $table->string('color'); // 标签颜色
            $table->timestamps();

            $table->foreign('forum_id')->references('id')->on('forums')->onDelete('cascade'); // 外键，关联板块id，同步删除
            $table->foreign('tag_group_id')->references('id')->on('tag_groups')->onDelete('cascade'); // 外键，关联标签组id，同步删除
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
        Schema::dropIfExists('tags');
    }
}
