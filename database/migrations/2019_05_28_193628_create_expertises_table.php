<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expertises', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('專長ID');
            $table->string('expertises',20)->comment('專長');
            //新增人
            $table->unsignedInteger('created_by')->nullable();
            //新增及更新的時間戳
            $table->timestamps();
            //修改人
            $table->unsignedInteger('updated_by')->nullable();
            //啟停用
            $table->softDeletes();

            //關聯
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
        Schema::dropIfExists('expertises');
    }
}
