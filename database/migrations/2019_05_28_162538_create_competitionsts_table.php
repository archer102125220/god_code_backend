<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionstsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('competitions', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->comment('競賽ID');
      $table->unsignedInteger('subject_id')->nullable()->comment('主題名稱');
      $table->unsignedInteger('competitions_name_id')->nullable()->comment('競賽名稱');
      $table->date('start_date')->comment('開始日期');
      $table->date('end_date')->comment('結束日期');
      $table->char('ranking', 5)->comment('名次');

      $table->unsignedInteger('created_by')->nullable()->comment('新增人');
      $table->timestamps();
      $table->unsignedInteger('updated_by')->nullable()->comment('修改人');
      $table->softDeletes()->comment('啟停用');


      //關聯
      $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('set null')->onUpdate('cascade');
      $table->foreign('competitions_name_id')->references('id')->on('competitions_names')->onDelete('set null')->onUpdate('cascade');
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
    Schema::dropIfExists('competitions');
  }
}
