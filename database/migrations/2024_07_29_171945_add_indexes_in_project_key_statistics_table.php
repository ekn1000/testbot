<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesInProjectKeyStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_key_statistics', function (Blueprint $table) {
            $table->index('project_id', 'project_id');
            $table->index('date', 'date');
            $table->index('device', 'device');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_key_statistics', function (Blueprint $table) {
            $table->dropIndex('project_id');
            $table->dropIndex('date');
            $table->dropIndex('device');
        });
    }
}
