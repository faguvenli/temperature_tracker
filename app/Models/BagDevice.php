<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class BagDevice extends Model
{
    use HasEagerLimit;

    protected $connection = 'tenant';

    protected $fillable = [
        "region_id",
        "bag_device_type_id",
        "device_model",
        "device_mac",
        "device_location",
        "serial_number",
        "temperature_calibration_trim",
        "temperature_max",
        "temperature_min",
    ];

    public function values() {
        return $this->hasMany(BagTksGprs::class, 'imei', 'serial_number')
            ->orderByDesc('date_time')
            ->limit(2);
    }
}
