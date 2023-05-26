<?php

namespace App\Http\AlarmClasses;

use App\Models\AlarmTracker;
use App\Models\EnvDevice;
use App\Models\OfflineTracker;
use App\Models\Tenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TemperatureChecker
{
    public function __invoke()
    {

        $databases = Tenant::all();


        foreach ($databases as $database) {
            //Config::set('database.connections.tenant.database', $database->database);
            config(['database.connections.tenant.database' => $database->database]);

            $temp_values = EnvDevice::query()
                
                ->select(
                    'env_devices.id',
                    'env_devices.device_mac',
                    DB::raw('ifnull(env_devices.temperature_max, 0) as temperature_max'),
                    DB::raw('ifnull(env_devices.temperature_min, 0) as temperature_min'),
                )
                ->where('env_devices.confirmed', true)
                ->where('env_devices.alarm_active', true)
                ->orderBy('env_devices.name')
                ->get();

            $oldDate = new \Carbon\Carbon();

            foreach ($temp_values as $temp_value) {
                Log::info($temp_value->device_mac);
                if ($temp_value->values->count() == 2) {
                    $latest = $temp_value->values[0];
                    $previous = $temp_value->values[1];
                } else {
                    continue;
                }

                $temp_value->temperature = $latest->temperature;
                $temp_value->old_temperature = $previous->temperature;

                $lastDate = new \Carbon\Carbon($latest->record_date);
                $temp_value->difference = $oldDate->diffInMinutes($lastDate);

                if ($temp_value->difference > 10) {
                    OfflineTracker::updateOrCreate([
                        'env_device_id' => $temp_value->id,
                        'message_sent' => 0
                    ],
                        [
                            'alarm_date' => $lastDate,
                            'temperature' => $temp_value->temperature ?? 0
                        ]);
                }

                if ($temp_value->temperature < $temp_value->temperature_min or $temp_value->temperature > $temp_value->temperature_max) {

                    AlarmTracker::updateOrCreate([
                        'env_device_id' => $temp_value->id,
                        'message_sent' => 0
                    ],
                        [
                            'alarm_date' => $lastDate,
                            'temperature' => $temp_value->temperature ?? 0
                        ]);


                    AlarmTracker::query()
                        ->where('message_sent', 0)
                        ->whereRaw('timestampdiff(MINUTE, created_at, updated_at) > 35')
                        ->delete();

                }
            }
            DB::disconnect('tenant');
        }
    }
}
