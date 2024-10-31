<?php

namespace App\Jobs;

use App\Services\ReCalculateValuesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class recalculateProjectKeysFrequencyOfCheatingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private  $project_id;
    private ReCalculateValuesService $reCalculateValuesService;
    public function __construct($project_id, ReCalculateValuesService $reCalculateValuesService)
    {
        $this -> project_id = $project_id;
        $this -> reCalculateValuesService = $reCalculateValuesService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->reCalculateValuesService->recalculateProjectKeysFrequencyOfCheating($this->project_id);
    }
}
