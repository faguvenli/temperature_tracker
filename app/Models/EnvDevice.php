<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class EnvDevice extends Model
{
    use HasEagerLimit;

    protected $connection = 'tenant';

    protected $fillable = [
        "region_id",
        "name",
        "device_mac",
        "confirmed",
        "device_type",
        "alarm_active",
        "temperature_calibration_trim",
        "humidity_calibration_trim",
        "temperature_max",
        "temperature_min",
        "humidity_max",
        "humidity_min",
        "region_id"
    ];

    public function values() {
        return $this->hasMany(EnvDeviceData::class, 'env_device_id', 'id')
            ->orderByDesc('record_date')
            ->limit(2);
    }
}
