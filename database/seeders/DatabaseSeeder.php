<?php

namespace Database\Seeders;

use App\Models\ProjectGroup;
use App\Models\Project;
use App\Models\ProjectTask;
use Database\Factories\ProjectTaskFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            PermissionSeeder::class,
            AdminSeeder::class
        ]);

       // ProjectGroup::factory(6)->create();
       // Project::factory(20)->create();
       // ProjectTask::factory(120)->create();
       /* $this->call([
            CalculateValuesSeeder::class,
        ]); */
    }
}
