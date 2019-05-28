<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->comment('索引編號');
            $table->string('unit')->nullable()->comment('識別名稱');
            $table->string('referable_type')->nullable()->comment('關聯模型');
            $table->unsignedInteger('referable_id')->nullable()->comment('關聯編號');
            $table->string('name')->comment('上傳檔案名稱');
            $table->string('realpath')->comment('檔案實際路徑');
            $table->string('extension')->comment('副檔名');
            $table->string('mimetype')->nullable()->comment('Mime類型');
            $table->bigInteger('size')->unsigned()->comment('檔案大小');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('files');
    }
}
