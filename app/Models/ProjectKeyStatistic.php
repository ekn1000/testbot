<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProjectKeyStatistic extends Model
{
    use HasFactory;

    const DEVICE_ALL = 0;
    const DEVICE_MOBILE = 1;
    const DEVICE_DESKTOP = 2;

    public static array $devices = [
        'all' => self::DEVICE_ALL,
        'mobile' => self::DEVICE_MOBILE,
        'desktop' => self::DEVICE_DESKTOP,
    ];
    public static function getDeviceKey($device)
    {
        return array_search($device, self::$devices, true);
    }

    public static function getDeviceValue($key)
    {
        return self::$devices[Str::lower($key)];
    }
    protected $fillable = [
        'project_key_id', 'sum_position', 'sum_cookies', 'sum_uniquedomains', 'sum_ymdomains',
        'sum_gadomains', 'device', 'avg_position_last', 'frequency_of_cheating', 'project_id', 'user_id', 'has_yesterday'
    ];

    public function project_key(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProjectKey::class, 'project_key_id');
    }
}
