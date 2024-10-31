<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectKey extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::created(function ($projectKey){
            $projectKey -> frequency_of_cheating = $projectKey->frequency * $projectKey->coefficient / 30;
        });

        static::updated(function ($projectKey){


            if($projectKey->isDirty('frequency') || $projectKey->isDirty('coefficient')) {
                $projectKey -> frequency_of_cheating = $projectKey->frequency * $projectKey->coefficient / 30;
            }
        });
    }
    protected $fillable = [
        'keyword', 'frequency', 'position_up', 'target_position', 'yesterday_position',
        'today_position','targeturl', 'getparameters','coefficient','frequency_of_cheating',
        'active', 'project_id'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'active' => 'boolean'
    ];
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }


    public function statistic(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectKeyStatistic::class, 'project_key_id');
    }
}
