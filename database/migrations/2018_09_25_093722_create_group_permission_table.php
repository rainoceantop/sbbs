<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建用户组-权限之多对多关联表
        Schema::create('group_permission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id'); // 用户组id
            $table->unsignedInteger('permission_id'); // 权限id
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('user_groups')->onDelete('cascade'); // 外键，关联用户组id，同步删除
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade'); // 外键，关联权限id，同步删除
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
        Schema::dropIfExists('group_permission');
    }
}
