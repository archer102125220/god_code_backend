<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetitionsOrganizersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('competitions_organizers', function (Blueprint $table) {
      $table->engine = 'InnoDB';
      $table->increments('id')->comment('主辦單位ID');
      $table->unsignedInteger('competitions_name_id')->nullable()->comment('競賽名稱');
      $table->unsignedInteger('organizer_id')->nullable()->comment('主辦名稱');

      $table->unsignedInteger('created_by')->nullable()->comment('新增人');
      $table->timestamps();
      $table->unsignedInteger('updated_by')->nullable()->comment('修改人');
      $table->softDeletes()->comment('啟停用');

      //關聯
      $table->foreign('competitions_name_id')->references('id')->on('competitions_names')->onDelete('set null')->onUpdate('cascade');
      $table->foreign('organizer_id')->references('id')->on('organizers')->onDelete('set null')->onUpdate('cascade');
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
    Schema::dropIfExists('competitions_organizers');
  }
}
