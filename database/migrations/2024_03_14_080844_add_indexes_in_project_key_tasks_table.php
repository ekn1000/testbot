<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesInProjectKeyTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_key_tasks', function (Blueprint $table) {
            $table->index('taskid', 'taskid');
            $table->index('user_id', 'user_id');
            $table->index('pid', 'pid');
            $table->index('status', 'status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_key_tasks', function (Blueprint $table) {
            $table->dropIndex('taskid');
            $table->dropIndex('user_id');
            $table->dropIndex('pid');
            $table->dropIndex('status');
        });
    }
}
