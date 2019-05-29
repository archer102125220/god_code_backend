<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWritingsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('writings', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->comment('文章ID');
      $table->string('writings')->comment('文章題目');
      $table->unsignedInteger('writing_type_id')->nullable()->comment('文章類別');
      $table->integer('writing_kinds')->comment('文章種類(0=文章,1=問題)');
      $table->string('content')->nullable()->defalut(null)->comment('文章內容');

      $table->unsignedInteger('created_by')->nullable()->comment('新增人');
      $table->timestamps();
      $table->unsignedInteger('updated_by')->nullable()->comment('修改人');
      $table->softDeletes()->comment('啟停用');

      //關聯
      $table->foreign('writing_type_id')->references('id')->on('writing_types')->onDelete('set null')->onUpdate('cascade');
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
    Schema::dropIfExists('writings');
  }
}
