<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectKeyTask extends Model
{
    use HasFactory;

    const STATUS_RECEIVED = 0;
    const STATUS_ENTERED = 1;
    const STATUS_FOUND = 2;
    const STATUS_VISITED = 3;
    const STATUS_NOTFOUND = 4;
    const STATUS_INTENTION = 5;

    public static array $statuses = [
        'received' => self::STATUS_RECEIVED,
        'entered' => self::STATUS_ENTERED,
        'found' => self::STATUS_FOUND,
        'visited' => self::STATUS_VISITED,
        'notfound' => self::STATUS_NOTFOUND,
        'intention' => self::STATUS_INTENTION,
    ];

    public static function getStatusKey(string $status) {
        return array_search($status, self::$statuses);
    }
    protected $fillable = [
        'targeturl', 'keyword',  'getparameters', 'project_key_id', 'user_id', 'taskid',
        'tid', 'tasktype', 'targetdomain', 'position', 'relevant_url', 'projectname',
        'pid','device', 'cookies', 'uniquedomains', 'ymdomains', 'uniquedomains', 'gadomains',
        'proxy', 'ip', 'project_id', 'status'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
    ];
    protected static function booted()
    {
        static::creating(function ($task) {
            $task->taskid =  Str::lower(Str::random(36));
        });
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id');
    }
}
