<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectGroup extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($projectGroup) {
            $projectGroup->api_key =  Str::lower(Str::random(32));
        });
    }
    protected  $fillable = ['name', 'comment', 'user_id'];

    protected $appends = [
        'count_keys', 'count_projects', 'count_frequency'
    ];
    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Project::class, 'group_id');
    }
    public function statistics(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(ProjectKeyStatistic::class, Project::class, 'group_id');
    }
   public function getCountKeysAttribute()
    {
        return $this->active_keys + $this->stopped_keys;
    }

    public function getCountProjectsAttribute()
    {
        return $this->active_projects + $this->stopped_projects;
    }
    public function getCountFrequencyAttribute()
    {
        return $this->active_frequency + $this->stopped_frequency;
    }
}
