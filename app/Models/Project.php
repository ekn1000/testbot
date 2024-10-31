<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($project) {
            $project->api_key =  Str::lower(Str::random(32));
        });
    }

    protected $fillable = [
        'name', 'targeturl', 'group_id', 'percentage_of_repeat_visits',
        'daily_volume_of_tasks', 'getparameters', 'active'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'active' => 'boolean'
    ];

    public function keys(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectKey::class, 'project_id');
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProjectGroup::class, 'group_id');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return  $this->hasMany(ProjectKeyTask::class, 'project_id');
    }

    public function statistics(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectKeyStatistic::class, 'project_id');
    }
}
