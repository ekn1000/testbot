<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectKeyStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_key_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_key_id')
            ->constrained()
            ->onDelete('cascade');
            $table->BigInteger('project_id')->unsigned()->default(0);
            $table->BigInteger('user_id')->unsigned()->default(0);
            $table->date('date');
            $table->unsignedInteger('sum_position')->default(0);
            $table->unsignedInteger('sum_cookies')->default(0);
            $table->unsignedInteger('sum_uniquedomains')->default(0);
            $table->unsignedInteger('sum_ymdomains')->default(0);
            $table->unsignedInteger('sum_gadomains')->default(0);
            $table->unsignedTinyInteger('device')->default(0);
            $table->unsignedDecimal('avg_position_last', 8, 1)->default(0);
            $table->boolean('has_yesterday')->default(false);
            $table->unsignedDecimal('frequency_of_cheating', $precision = 18, $scale = 4)->default(0);
            $table->unsignedInteger('received')->default(0);
            $table->unsignedInteger('intention')->default(0);
            $table->unsignedInteger('entered')->default(0);
            $table->unsignedInteger('found')->default(0);
            $table->unsignedInteger('visited')->default(0);
            $table->unsignedInteger('notfound')->default(0);
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
        Schema::dropIfExists('project_key_statistics');
    }
}
