<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('comment')->nullable();
            $table->integer('active_projects')->unsigned()->default(0);
            $table->integer('stopped_projects')->unsigned()->default(0);
            $table->integer('active_keys')->unsigned()->default(0);
            $table->integer('stopped_keys')->unsigned()->default(0);
            $table->BigInteger('active_frequency')->unsigned() -> default(0);
            $table->BigInteger('stopped_frequency')->unsigned() -> default(0);
            $table->BigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('api_key', 32)->nullable();
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
        Schema::dropIfExists('project_groups');
    }
}
