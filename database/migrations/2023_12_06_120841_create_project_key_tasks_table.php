<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectKeyTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_key_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('taskid',36);
            $table->string('tid', 36)->nullable();
            $table->string('tasktype')->nullable();
            $table->string('targetdomain')->nullable();
            $table->string('targeturl')->nullable();
            $table->string('keyword')->nullable();
            $table->integer('position')->unsigned()->default(0);
            $table->string('relevant_url')->nullable();
            $table->string('getparameters', 128)->nullable();
            $table->string('projectname', 128)->nullable();
            $table->string('pid')->nullable();
            $table->string('device', 8)->nullable();
            $table->unsignedMediumInteger('cookies')->default(0);
            $table->unsignedMediumInteger('uniquedomains')->default(0);
            $table->unsignedMediumInteger('ymdomains')->default(0);
            $table->unsignedMediumInteger('gadomains')->default(0);
            $table->string('proxy')->nullable();
            $table->string('ip')->nullable();
            $table->foreignId('project_key_id')->constrained('project_keys')
                ->onDelete('cascade');
            $table->BigInteger('project_id')->unsigned()->default(0);
            $table->BigInteger('user_id')->unsigned();
            $table->unsignedTinyInteger('status')->default(0);
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
        Schema::dropIfExists('project_key_tasks');
    }
}
