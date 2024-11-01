<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_statistics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id')->unsigned();
            $table->date('date');
            $table->unsignedTinyInteger('device')->default(0);
            $table->bigInteger('total_received')->unsigned()->default(0);
            $table->bigInteger('total_entered')->unsigned()->default(0);
            $table->bigInteger('total_found')->unsigned()->default(0);
            $table->bigInteger('total_visited')->unsigned()->default(0);
            $table->bigInteger('total_notfound')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_statistics');
    }
}
