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
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('成員ID');
            //uniqid 索引唯一值
            $table->string('username')->uniqid()->comment('帳號');
            $table->string('password')->comment('密碼');
            $table->string('number', 20)->comment('學號、教師證');
            $table->string('email')->comment('電子信箱');
            $table->string('name', 10)->comment('名字');
            $table->string('introduction')->nullable()->comment('自我介紹');
            $table->date('graduation')->nullable()->comment('畢業日期');

            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
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
