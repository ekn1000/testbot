<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectKey;
use App\Models\ProjectKeyStatistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectKeyStatisticController extends Controller
{
    public function index(Request $request)
    {

        $end_date =  Carbon::today();;

        $start_date = Carbon::parse($end_date)->subDays(5);


        $device = 0;
        $dates = [];
        $orderByField = 'frequency';
        $orderSortDirection = 'desc';

        if($request -> has('device_id')) {
            $device = (int) $request -> get('device_id');
        }

        if($request->get('date_range')) {
            $start_date = Carbon::parse($request->get('date_range')[0]);
            $end_date = Carbon::parse($request->get('date_range')[1]);
        }

        if($request -> has('order_by')) {
            list($orderByField, $orderSortDirection) = explode('|', $request->get('order_by'));
        }
        $daysDiff = $end_date->diffInDays($start_date);


        //$test = ProjectKeyStatistic::get()->groupBy('date');
        //dd($test);
        $project_keys = ProjectKey::query()
            -> whereHas('statistic', function ($query) use ($start_date, $end_date, $device) {
            $query->where('user_id', auth()->id());
            $query->where('device', $device);
            $query -> whereDate('date', '>=', $start_date);
            $query->whereDate('date', '<=', $end_date);
        }) -> with('statistic', function ($query) use ($start_date, $end_date, $device, $orderByField, $orderSortDirection) {
            $query->where('user_id', auth()->id());
            $query->where('device', $device);
            $query -> whereDate('date', '>=', $start_date);
            $query->whereDate('date', '<=', $end_date);
            $query->select('id', 'project_key_id','user_id','device', 'date',
                'sum_position', 'sum_cookies', 'sum_uniquedomains', 'sum_ymdomains', 'sum_gadomains',
                'created_at', 'avg_position_last', 'received','entered', 'visited','found','notfound');

        });

        if($request->get('project_id')) {
            $project_keys = $project_keys -> where('project_id', $request->get('project_id'));
        }
        $project_keys = $project_keys -> select('id', 'keyword', 'frequency', 'frequency_of_cheating', 'project_id')-> orderBy($orderByField, $orderSortDirection)->get();

        $project_keys_statistic = [];

        foreach ($project_keys as $project_key) {
            //$project_keys_statistic[];

           $statistic = $project_key -> statistic -> groupBy('date')->toArray();
            foreach ($statistic as $key=> $statistic_item) {
                $statistic[$key] = $statistic_item[0];
            }

            $dates = array_unique(array_merge($dates, array_keys($statistic)));

            $project_keys_statistic[] = [
                'keyword' => $project_key->keyword,
                'frequency' => $project_key -> frequency,
                'frequency_of_cheating' => $project_key -> frequency_of_cheating,
                'statistic' => $statistic
            ];
        }


        array_multisort(
            array_map('strtotime',$dates),
            SORT_DESC,
            $dates
        );

        return ['dates' => $dates, 'project_keys_statistic' => $project_keys_statistic];
    }

    public function show($id)
    {
        $project_key_statistic = ProjectKeyStatistic::with('project_key') ->findOrFail($id);
        if(Auth::user() -> id !== $project_key_statistic -> user_id) {
            abort(404);
        }

        $project_key_statistic -> device = ProjectKeyStatistic::getDeviceKey($project_key_statistic -> device);
        return $project_key_statistic;
    }

    public function updateStatistics()
    {
        ProjectKeyStatistic::aggregateStatistics();
        return response()->json(['message' => 'Project statistics updated successfully.']);
    }
}
