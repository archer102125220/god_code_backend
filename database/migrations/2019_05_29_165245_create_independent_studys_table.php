<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndependentStudysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('independent_studys', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('專題ID');
            $table->unsignedInteger('subject_id')->nullable()->comment('專題主題');
            $table->unsignedInteger('independent_studys_group_id')->nullable()->comment('專題組別');
            $table->unsignedInteger('team_name_id')->nullable()->comment('製作隊伍');
            $table->string('url')->nullable()->comment('專題連結');
            $table->date('publish_time')->nullable()->comment('發表時間');
            //新增人
            $table->unsignedInteger('created_by')->nullable();
            //新增及更新的時間戳
            $table->timestamps();
            //修改人
            $table->unsignedInteger('updated_by')->nullable();
            //啟停用
            $table->softDeletes();

            //關聯
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('independent_studys_group_id')->references('id')->on('independent_studys_groups')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('team_name_id')->references('id')->on('team_names')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('independent_studys');
    }
}
