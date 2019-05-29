<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWritingTypesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('writing_types', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->comment('文章類型ID');
      $table->string('writing_types', 20)->comment('文章類型');

      $table->unsignedInteger('created_by')->nullable()->comment('新增人');
      $table->timestamps();
      $table->unsignedInteger('updated_by')->nullable()->comment('修改人');
      $table->softDeletes()->comment('啟停用');

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
    Schema::dropIfExists('writing_types');
  }
}
