<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户表
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); // 用户的名称
            $table->string('username')->unique(); // 登录帐号
            $table->string('password');  // 登录密码
            $table->string('avatar')->default('/imgs/user.jpeg'); // 头像链接，设置默认
            $table->tinyInteger('is_super_admin')->default(0); // 是否管理员，0：非管理员，1：管理员。默认0
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
