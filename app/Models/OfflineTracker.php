<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflineTracker extends Model
{
    protected $connection = 'tenant';

    protected $fillable = ["env_device_id", "alarm_date", "message_sent", "temperature"];

    public function envDevice() {
        return $this->belongsTo(EnvDevice::class);
    }
}
