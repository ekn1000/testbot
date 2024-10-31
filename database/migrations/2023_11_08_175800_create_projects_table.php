<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('api_key', 32);
            $table->string('name');
            $table->string('targeturl');
            $table->unsignedDecimal('daily_volume_of_keys',  $precision = 22, $scale = 4)->default(0);
            $table->tinyInteger('percentage_of_repeat_visits')->unsigned()->default(0);
            $table->text('getparameters')->nullable();
           //$table->integer('days_of_pumping')->unsigned();
            $table->smallInteger('active_keys')->unsigned()->default(0);
            $table->smallInteger('stopped_keys')->unsigned()->default(0);
            $table->BigInteger('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('project_groups')->onDelete('cascade');
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
