<?php

namespace App\Services;

use App\Models\Project;
use App\Models\ProjectKeyStatistic;
use App\Models\ProjectKeyTask;
use Carbon\Carbon;


class getTaskService
{

    protected ProjectKeyStatisticService $projectKeyStatisticService;
    public function __construct(ProjectKeyStatisticService $projectKeyStatisticService)
    {
        $this->projectKeyStatisticService = $projectKeyStatisticService;
    }
    public function action($api_key, $taskData)
    {


        $project = Project::where('api_key', $api_key)
            -> firstOrFail();

        if(!$project -> active) {
            return ['status' => 'stopped'];
        }

        $keys = $project->keys()->where('active', 1)
        -> whereDoesntHave('statistic' ,function ($query) {
            $query -> whereDate('date', Carbon::now());
            $query -> where('device', ProjectKeyStatistic::DEVICE_ALL);
            $query -> whereColumn('visited', '>=', 'project_keys.frequency_of_cheating');
        })

        -> withSum(['statistic' =>   function ($query) {
                $query -> whereDate('date', Carbon::now());
                $query -> where('device', ProjectKeyStatistic::DEVICE_ALL);
            }], 'visited')

           ->get();
        $current_number_of_minutes = diffInMinutesFromTodayToNow();

        $frequency_of_cheating = $keys->reduce(function ($carry, $item) use ($current_number_of_minutes) {
            return $carry + $item['frequency_of_cheating'] / 1440 * $current_number_of_minutes - (int) $item['statistic_sum_visited'];
        });

        if($frequency_of_cheating > 0) {

            $prob = rand() / getrandmax() * $frequency_of_cheating;
            foreach ($keys as $item) {
                if ($prob <= $item['frequency_of_cheating'] / 1440 * $current_number_of_minutes - (int) $item['statistic_sum_visited']) {
                    $key = $item;
                    break;
                }
                $prob -= $item['frequency_of_cheating'] / 1440 * $current_number_of_minutes;
            }
            $targeturl = $key['targeturl'];
            if($targeturl == '') {
                $targeturl = $project->targeturl;
            }

            $task = ProjectKeyTask::create([
                'pid' => $taskData['pid'],
                'targeturl'=> $targeturl,
                'keyword' => $key['keyword'],
                'getparameters' => $key['getparameters'],
                'device' => $taskData['device'],
                'project_key_id'=> $key['id'],
                'project_id' => $key['project_id'],
                'status' => ProjectKeyTask::$statuses['received'],
                'user_id' => $project->group->user_id
            ]);
            $this->projectKeyStatisticService->action($task->toArray());
            $return = [
                'pid' => $task['pid'],
                'targeturl' => $task['targeturl'],
                'keyword' => $task['keyword'],
                'getparameters' => $task['getparameters'],
                'projectid' => $task['project_id'],
                'projectkeyid' => $task['project_key_id'],
                'taskid' => $task['taskid'],
                'status' => 'active',
            ];
        } else {
            $return = ['status' => 'stopped'];
        }

        return json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }
}
