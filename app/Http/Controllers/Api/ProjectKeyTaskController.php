<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectKeyTaskStoreRequest;
use App\Models\ProjectKeyTask;
use App\Services\getTaskService;
use App\Services\ProjectKeyStatisticService;
use Illuminate\Http\Request;

class ProjectKeyTaskController extends Controller
{
    protected getTaskService $getTaskService;
    protected ProjectKeyStatisticService $projectKeyStatisticService;
    public function __construct(getTaskService $getTaskService, ProjectKeyStatisticService $projectKeyStatisticService)
    {
        $this -> getTaskService = $getTaskService;
        $this -> projectKeyStatisticService = $projectKeyStatisticService;
    }

    public function getTask($api_key, ProjectKeyTaskStoreRequest $request)
    {
        return  $this->getTaskService -> action($api_key, $request->validated());
    }

    public function update(Request $request)
    {
        $return_data = [
            'status' => 'error',
            'data' => null,
            'message' => 'taskid не найден'
        ];

        if(ProjectKeyTask::where('taskid', $request->get('taskid'))->exists()) {
            $projectKeyTask = ProjectKeyTask::where('taskid', $request->get('taskid'))->firstOrFail();
            $projectKeyTask->update($request->except('status'));
            $projectKeyTask->status = ProjectKeyTask::$statuses[$request->get('status')];
            $projectKeyTask->save();
            $this -> projectKeyStatisticService -> action($projectKeyTask->toArray());
            $return_data['data'] = $projectKeyTask;
            $return_data['status'] = 'success';
            $return_data['message'] = 'Данные по заданию успешно обновлены';

        }

        return json_encode($return_data,JSON_UNESCAPED_UNICODE);
    }
}
