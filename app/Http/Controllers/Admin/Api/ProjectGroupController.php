<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectGroup;
use App\Models\ProjectKeyStatistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user_id = $request->get('user_id');
        $project_groups = ProjectGroup::where('user_id', $user_id)
            ->withSum(['projects' => function ($query) {
              $query -> where('active', 1);
            }], 'daily_volume_of_keys')
            ->withSum(['statistics' => function ($query) {
                $query -> whereDate('date', Carbon::now());
                $query -> where('device', ProjectKeyStatistic::DEVICE_ALL);
            }], 'received')
            ->withSum(['statistics' => function ($query) {
                $query -> whereDate('date', Carbon::now());
                $query -> where('device', ProjectKeyStatistic::DEVICE_ALL);
            }], 'entered')
            ->withSum(['statistics' => function ($query) {
                $query -> whereDate('date', Carbon::now());
                $query -> where('device', ProjectKeyStatistic::DEVICE_ALL);
            }], 'found')
            ->withSum(['statistics' => function ($query) {
                $query -> whereDate('date', Carbon::now());
                $query -> where('device', ProjectKeyStatistic::DEVICE_ALL);
            }], 'visited')
            ->withSum(['statistics' => function ($query) {
                $query -> whereDate('date', Carbon::now());
                $query -> where('device', ProjectKeyStatistic::DEVICE_ALL);
            }], 'notfound')
            -> orderBy('created_at', 'desc')->get();

        return $project_groups;
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
            'name'=>'required',
        ]);

        $projectGroup = ProjectGroup::create($request->all());

        return  $projectGroup;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $projectGroup = ProjectGroup::findOrFail($id);

        return $projectGroup;
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
        $projectGroup = ProjectGroup::findOrFail($id);
        $projectGroup->update($request->all());
        return  $projectGroup;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projectGroup = ProjectGroup::findOrFail($id);
        $projectGroup->delete();
        return $projectGroup;
    }
    public function getOptionList(Request $request)
    {

        $user_id = $request->get('user_id');
        $project_groups = ProjectGroup::where('user_id', $user_id)->select('id', 'name')->get();
        $options = [];
        foreach ($project_groups as $group) {
            $options[]= [
                'label' => $group->name,
                'value' => $group->id
            ];
        }
        return json_encode($options);
    }

    public function generateApiKey($id)
    {
        $projectGroup = ProjectGroup::findOrFail($id);
        $projectGroup->api_key =  Str::lower(Str::random(32));
        $projectGroup -> save();
        return $projectGroup->api_key;
    }
}
