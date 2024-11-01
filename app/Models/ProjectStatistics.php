<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectStatistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'date',
        'device',
        'total_received',
        'total_intention',
        'total_entered',
        'total_found',
        'total_visited',
        'total_notfound',
    ];

    public static function aggregateStatistics()
    {
        $statistics = ProjectKeyStatistic::select('project_id','date','device',
                DB::raw('SUM(received) as total_received'),
                DB::raw('SUM(intention) as total_intention'),
                DB::raw('SUM(entered) as total_entered'),
                DB::raw('SUM(found) as total_found'),
                DB::raw('SUM(visited) as total_visited'),
                DB::raw('SUM(notfound) as total_notfound')
            )
            ->groupBy('project_id','date','device')
            ->get();

        foreach ($statistics as $stat) {
            self::updateOrCreate(
                [
                    'project_id' => $stat->project_id,
                    'date' => $stat->date,
                    'device' => $stat->device,
                ],
                [
                    'total_received' => $stat->total_received,
                    'total_entered' => $stat->total_entered,
                    'total_found' => $stat->total_found,
                    'total_visited' => $stat->total_visited,
                    'total_notfound' => $stat->total_notfound,
                ]
            );
        }
    }
}
