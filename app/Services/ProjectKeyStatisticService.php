<?php

namespace App\Services;

use App\Models\ProjectKey;
use App\Models\ProjectKeyStatistic;
use App\Models\ProjectKeyTask;
use Carbon\Carbon;

class ProjectKeyStatisticService
{
    protected array $projectKeyTaskData;
    protected int $device;

    public function action($projectKeyTaskData)
    {

        $this->projectKeyTaskData = $projectKeyTaskData;
        $this -> device = ProjectKeyStatistic::getDeviceValue($projectKeyTaskData['device']);
        if(ProjectKeyStatistic::where('project_key_id', $projectKeyTaskData['project_key_id'])
            -> whereDate('created_at', now()->today()) -> where('device', $this->device) -> exists()) {
            $projectKeyStatistic = ProjectKeyStatistic::where('project_key_id', $projectKeyTaskData['project_key_id'])
                -> whereDate('created_at', now()->today()) -> where('device', $this->device) -> firstOrFail();
        } else {
            $projectKeyStatistic = new ProjectKeyStatistic();
            $projectKeyStatistic -> project_key_id = $projectKeyTaskData['project_key_id'];
            $avg_position_last = 0;
            $has_yesterday = false;
            if(ProjectKeyStatistic::where('project_key_id', $projectKeyTaskData['project_key_id'])
                -> whereDate('created_at', '<' , Carbon::now()) -> where('device', $this->device) ->  exists()) {
                $last_statistic = ProjectKeyStatistic::where('project_key_id', $projectKeyTaskData['project_key_id'])
                    -> whereDate('created_at', '<' , Carbon::now()) -> where('device', $this->device)
                    ->orderBy('created_at', 'desc') -> first();
                  if($last_statistic -> found > 0) {
                      $avg_position_last = round($last_statistic ->  sum_position / $last_statistic -> found , 1);
                  }

            }
            if(ProjectKeyStatistic::where('project_key_id', $projectKeyTaskData['project_key_id'])
                -> whereDate('created_at', Carbon::yesterday()) -> where('device', $this->device) ->  exists()) {
                $has_yesterday = true;
            }
            $projectKeyStatistic -> project_id = $projectKeyTaskData['project_id'];
            $projectKeyStatistic -> user_id = $projectKeyTaskData['user_id'];
            $projectKeyStatistic ->date = Carbon::now();
            $projectKeyStatistic -> avg_position_last = $avg_position_last;
            $projectKeyStatistic -> has_yesterday = $has_yesterday;
            $projectKeyStatistic -> device = $this->device;
            $projectKey = ProjectKey::findOrFail($projectKeyTaskData['project_key_id']);
            $projectKeyStatistic -> frequency_of_cheating = $projectKey->frequency_of_cheating;

            //$projectKeyStatistic -> created_at = $projectKeyTaskData['created_at'];
           // $projectKeyStatistic -> updated_at = $projectKeyTaskData['updated_at'];

            $projectKeyStatistic -> save();
        }
        $this->update($projectKeyStatistic);
        if($this -> device !== ProjectKeyStatistic::DEVICE_ALL) {
            $this -> projectKeyTaskData['device'] = ProjectKeyStatistic::getDeviceKey(ProjectKeyStatistic::DEVICE_ALL);
            $this -> action($this -> projectKeyTaskData);
        }
    }


    public function update($projectKeyStatistic)
    {
        $this->updateStatisticCounter($projectKeyStatistic);
        if($this -> projectKeyTaskData['status'] === ProjectKeyTask::STATUS_FOUND) {
            $projectKeyStatistic -> sum_position = $projectKeyStatistic -> sum_position + $this->projectKeyTaskData['position'];
            $projectKeyStatistic -> sum_cookies = $projectKeyStatistic -> sum_cookies + $this->projectKeyTaskData['cookies'];
            $projectKeyStatistic -> sum_uniquedomains =  $projectKeyStatistic -> sum_uniquedomains + $this->projectKeyTaskData['uniquedomains'];
            $projectKeyStatistic -> sum_ymdomains = $projectKeyStatistic -> sum_ymdomains + $this->projectKeyTaskData['ymdomains'];
            $projectKeyStatistic -> sum_gadomains = $projectKeyStatistic -> sum_gadomains + $this->projectKeyTaskData['gadomains'];
        }
        $projectKeyStatistic -> save();

    }
    protected function updateStatisticCounter($projectKeyStatistic)
    {
        $statusName = ProjectKeyTask::getStatusKey($this->projectKeyTaskData['status']);
        $projectKeyStatistic -> $statusName = $projectKeyStatistic -> $statusName + 1;
    }
}
