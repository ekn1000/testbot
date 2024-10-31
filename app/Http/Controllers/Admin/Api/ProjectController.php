<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectGroup;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        Gate::authorize('show-project-group', ProjectGroup::find($request->get('group_id')));
        $projects = Project::where('group_id', $request->get('group_id'))
            -> orderBy('created_at', 'desc')
            ->get();
        return $projects;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'group_id' => 'required',
            'targeturl' => 'required'
        ]);

        $project = Project::create($request->all());
        return $project;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::findOrFail($id);
        return $project;
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
        $request->validate([
            'name' => 'required',
            'group_id' => 'required',
            'targeturl' => 'required'
        ]);
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return $project;
    }
    public function getOptionList(Request $request)
    {
        $group_id = $request->get('group_id');
        $projects = Project::where('group_id', $group_id)->select('id', 'name')->get();
        $options = [];
        foreach ($projects as $project) {
            $options[]= [
                'label' => $project->name,
                'value' => $project->id
            ];
        }
        return json_encode($options);
    }





}
