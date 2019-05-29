<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->unsignedInteger('research_id')->nullable()->comment('研究領域');
            $table->unsignedInteger('team_name_id')->nullable()->comment('作者');
            $table->foreign('research_id')->references('id')->on('researchs')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('team_name_id')->references('id')->on('team_names')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('research_id');
        });
    }
}
