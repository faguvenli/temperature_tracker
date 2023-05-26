<?php

namespace App\Http\Actions;

use App\Models\AlarmTracker;
use App\Models\EnvDevice;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class AlarmAction
{
    public function checkTemperature()
    {
        $temp_values = EnvDevice::query()
            
            ->select(
                'env_devices.id',
                DB::raw('ifnull(env_devices.temperature_max, 0) as temperature_max'),
                DB::raw('ifnull(env_devices.temperature_min, 0) as temperature_min'),
            )
            ->where('env_devices.confirmed', 1)
            ->orderBy('env_devices.name')
            ->get();

        $oldDate = new \Carbon\Carbon();

        foreach($temp_values as $temp_value) {
            if($temp_value->values->count() == 2) {
                $latest = $temp_value->values[0];
                $previous = $temp_value->values[1];
            } else {
                continue;
            }

            $temp_value->temperature = $latest->temperature;
            $temp_value->old_temperature = $previous->temperature;

            $lastDate = new \Carbon\Carbon($latest->record_date);
            $temp_value->difference = $oldDate->diffInMinutes($lastDate);

            //Offline
            if($temp_value->difference > 10) {
                $temp_value->offline_time = $lastDate->format('d.m.Y H:i');
            }

            if($temp_value->temperature < $temp_value->temperature_min or $temp_value->temperature > $temp_value->temperature_max) {
                AlarmTracker::create([
                    'env_device_id' => $temp_value->id,
                    'alarm_date' => $lastDate,
                    'temperature' => $temp_value->temperature
                ]);
            }
        }
    }
}
