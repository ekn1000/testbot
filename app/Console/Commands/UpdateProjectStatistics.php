<?php

namespace App\Console\Commands;

use App\Models\ProjectStatistics;
use Illuminate\Console\Command;

class UpdateProjectStatistics extends Command
{
    protected $signature = 'statistics:update';
    protected $description = 'Update project statistics from project_key_statistics';

    public function handle()
    {
        ProjectStatistics::aggregateStatistics();
        $this->info('Project statistics updated successfully.');
    }
}
