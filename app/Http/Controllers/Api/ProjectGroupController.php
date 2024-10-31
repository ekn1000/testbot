<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectKeyTaskStoreRequest;
use App\Models\ProjectGroup;
use App\Models\ProjectKeyStatistic;
use App\Models\ProjectKeyTask;
use App\Services\getTaskService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProjectGroupController extends Controller
{
    protected getTaskService $getTaskService;

    public function __construct(getTaskService $getTaskService)
    {
        $this -> getTaskService = $getTaskService;
    }

    public function getTaskFromProjectGroup( ProjectKeyTaskStoreRequest $request, $project_group_api_key)
    {


        //Профиль id
        $pid = $request->get('pid');

        //Не задан pid
        if($pid == '') {
            return ['err' => 'Err pid','status' => 'stopped'];
        }

        //Выбираем Группу проектов по id
        $projectGroup = ProjectGroup::where('api_key', $project_group_api_key)->firstOrFail();

        //Получаем все активные проекты в группе которые профиль не посещал
        $projects = $projectGroup -> projects()
            ->where('active', 1)
            ->where('active_keys', '>', 0)
            -> whereDoesntHave('tasks', function (Builder $query) use ($pid){
                $query -> where('pid',  $pid);
                $query -> where('status', ProjectKeyTask::$statuses['visited']);
            })
            ->withSum(['statistics' =>   function ($query) {
                $query -> whereDate('date', Carbon::now());
                $query -> where('device', ProjectKeyStatistic::DEVICE_ALL);
            }], 'visited')
            -> get();
            $current_number_of_minutes = diffInMinutesFromTodayToNow();
        $daily_volume_of_task = $projects->reduce(function ($carry, $item ) use ($current_number_of_minutes) {
            return $carry + ($item['daily_volume_of_keys'] / 1440 * $current_number_of_minutes - (int) $item['statistics_sum_visited']) ;
        });

        //$projects = $projects->toArray();

        //echo $daily_volume_of_task . "\r\n";
        $api_key = null;
        if($daily_volume_of_task > 0) {
            $prob = rand() / getrandmax() * $daily_volume_of_task;
            foreach ($projects as $item) {
                if ($prob <= $item['daily_volume_of_keys'] / 1440 * $current_number_of_minutes - (int) $item['statistics_sum_visited']) {
                    $api_key = $item['api_key'];
                    break;
                }
                $prob -= ($item['daily_volume_of_keys'] / 1440 * $current_number_of_minutes - (int) $item['statistics_sum_visited']);
            }
            if($api_key) {
                $return = $this->getTaskService -> action($api_key, $request->validated());
            } else {
                $return = ['status' => 'stopped'];
            }

        } else {
            $return = ['status' => 'stopped'];
        }
        return $return;
        //return json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }
}
