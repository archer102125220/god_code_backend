<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResearchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('researchs', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('研究ID');
            $table->unsignedInteger('research_type_id')->nullable()->comment('研究領域類型');
            $table->string('researchs')->comment('研究領域');
            //新增人
            $table->unsignedInteger('created_by')->nullable();
            //新增及更新的時間戳
            $table->timestamps();
            //修改人
            $table->unsignedInteger('updated_by')->nullable();
            //啟停用
            $table->softDeletes();

            //關聯
            $table->foreign('research_type_id')->references('id')->on('research_types')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('researchs');
    }
}
