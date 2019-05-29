<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('organizers', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->comment('主辦單位ID');
      $table->string('organizers', 50)->comment('主辦名稱');

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
    Schema::dropIfExists('organizers');
  }
}
