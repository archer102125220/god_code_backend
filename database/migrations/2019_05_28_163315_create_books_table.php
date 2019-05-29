<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('books', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->comment('書籍ID');
      $table->string('books', 50)->comment('書籍名稱');
      $table->unsignedInteger('publisher_id')->nullable()->comment('出版社名稱');
      $table->date('year_publication')->comment('出版日期');

      $table->unsignedInteger('created_by')->nullable()->comment('新增人');
      $table->timestamps();
      $table->unsignedInteger('updated_by')->nullable()->comment('修改人');
      $table->softDeletes()->comment('啟停用');


      //關聯
      $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('set null')->onUpdate('cascade');
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
    Schema::dropIfExists('books');
  }
}
