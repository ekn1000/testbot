<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_keys', function (Blueprint $table) {
            $table->id();
            $table->text('keyword');
            $table->integer('frequency')->unsigned() -> default(0);
            $table->tinyInteger('position_up')->unsigned() -> default(0);
            $table->integer('today_position')->unsigned()->default(0);
            $table->integer('yesterday_position')->unsigned()->default(0);
            $table->tinyInteger('target_position')->unsigned()->default(0);
            $table->string('targeturl')->nullable();
            $table->string('getparameters', 128)->nullable();
            $table->unsignedDecimal('coefficient', $precision = 5, $scale = 2)->default(0.1);
            $table->unsignedDecimal('frequency_of_cheating', $precision = 18, $scale = 4)->default(0);
            $table->boolean('active')->default(false);
            $table->foreignId('project_id')->constrained('projects')
                ->onDelete('cascade');
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
        Schema::dropIfExists('project_keys');
    }
}
