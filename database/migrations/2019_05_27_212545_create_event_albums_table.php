<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_albums', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id')->comment('索引');
            $table->string('event_albums', 50)->comment('活動集錦');
            $table->unsignedInteger('event_type_id')->nullable()->comment('活動類型');
            $table->unsignedInteger('created_by')->nullable();
            $table->timestamps();
            $table->unsignedInteger('updated_by')->nullable();
            $table->softDeletes();

            $table->foreign('event_type_id')->references('id')->on('event_types')->onDelete('set null')->onUpdate('cascade');
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
        Schema::dropIfExists('event_albums');
    }
}
