<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectGroup;
use App\Models\ProjectKeyTask;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectKeyTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const ITEM_PER_PAGE = 15;
    public function index(Request $request)
    {
       $filters = $request->get('filters');

        $limit = Arr::get($request->all(), 'limit', static::ITEM_PER_PAGE);
        $project_key_tasks_query = ProjectKeyTask::query()
        ->where('user_id', auth('sanctum')->user()->id);

        if($request->get('project_id')) {
            $project_key_tasks_query = $project_key_tasks_query
             ->where('project_id', $request->get('project_id'));
        }

        foreach ($filters as $filter) {
                if($filter['value']) {
                    $project_key_tasks_query = $project_key_tasks_query
                        ->where($filter['prop'], 'like',  $filter['value'] . '%');
                }
        }
        $project_key_tasks = $project_key_tasks_query
            ->OrderBy('id', 'desc')->fastPaginate($limit);

        //$project_key_tasks = ProjectKeyTask::where('user_id', auth('sanctum')->user()->id)->take(100)->get();
        return  $project_key_tasks;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }

    public function filterOptions(Request $request)
    {
        $filters = [];
        /*$projects = DB::table('project_groups')->where('user_id', Auth::user() -> id)
            -> leftJoin('projects', function ($join) {
                $join->on('project_groups.id', '=', 'projects.group_id');
            }) -> get([ 'projects.id', 'projects.name']); */
        $projects = ProjectGroup::where('user_id', Auth::user() -> id)
            -> whereHas('projects', function ($query) {
                $query->whereHas('statistics');
            })
            ->with('projects', function ($query) use ($request) {
                $query->whereHas('statistics');
                $query -> select('id', 'name', 'group_id');
            }) ->select('id', 'name')->get();
        $filters['projects'] = $projects;

        return $filters;
    }
}
