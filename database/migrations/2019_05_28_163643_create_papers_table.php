<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePapersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('papers', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->comment('書籍ID');
      $table->unsignedInteger('subjects_id')->nullable()->comment('主題名稱');
      $table->string('papers_types')->comment('論文類型(0=論文,1=國科會)');
      $table->date('year_publication')->comment('發表年');

      $table->unsignedInteger('created_by')->nullable()->comment('新增人');
      $table->timestamps();
      $table->unsignedInteger('updated_by')->nullable()->comment('修改人');
      $table->softDeletes()->comment('啟停用');


      //關聯
      $table->foreign('subjects_id')->references('id')->on('subjects')->onDelete('set null')->onUpdate('cascade');
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
    Schema::dropIfExists('papers');
  }
}
