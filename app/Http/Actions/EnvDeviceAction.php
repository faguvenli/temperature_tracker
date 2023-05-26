<?php

namespace App\Http\Actions;

use App\Models\AlarmTracker;
use App\Models\EnvDevice;
use App\Models\Region;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class EnvDeviceAction
{
    protected $alarm = false;

    public function store($data)
    {

        EnvDevice::create($data);

        session()->flash('success', 'kaydedildi');
        return redirect()->route('env-devices.index');
    }

    public function update($envDevice, $data)
    {

        $envDevice->update($data);

        session()->flash('success', 'güncellendi');
        return redirect()->route('env-devices.edit', $envDevice);
    }

    public function getDeviceTypes()
    {
        return getTypes([
            ["id" => 1, "name" => "Nemsiz Model"],
            ["id" => 2, "name" => "Nemli Model"],
        ]);
    }

    public function getConfirmValues()
    {
        return getTypes([
            ["id" => 0, "name" => "Onaysız"],
            ["id" => 1, "name" => "Onaylı"],
        ]);
    }

    public function getAlarmValues()
    {
        return getTypes([
            ["id" => 0, "name" => "Pasif"],
            ["id" => 1, "name" => "Aktif"],
        ]);
    }

    public function getRegions() {
        return Region::query()
            ->select('name', 'id')
            ->orderBy('name')
            ->where('device_type', 'Çevre Cihazları')
            ->get();
    }

    public function refreshFeed() {
        $regionDatabase = Config::get('database.connections.mysql.database');
        $temp_values = EnvDevice::query()

            ->select(
                'env_devices.id',
                DB::raw('COALESCE(regions.name, "Bölge Seçilmemiş") as region_name'),
                'env_devices.name',
                'env_devices.device_mac',
                DB::raw('COALESCE(env_devices.temperature_max, 0) as temperature_max'),
                DB::raw('COALESCE(env_devices.temperature_min, 0) as temperature_min'),
                DB::raw('COALESCE(env_devices.humidity_min, 0) as humidity_min'),
                DB::raw('COALESCE(env_devices.humidity_max, 0) as humidity_max')
            )
            ->leftJoin($regionDatabase.'.regions as regions', 'regions.id', '=', 'env_devices.region_id')
            ->where('env_devices.confirmed', 1)
            ->orderBy('env_devices.name');

        if(auth()->user()->isPanelUser) {
            if(!auth()->user()->isSuperAdmin) {
              //  $temp_values->whereIn('region_id', auth()->user()->regions->pluck('id')->toArray());
            } elseif(session()->get('env_device_region') && !is_null(session()->get('env_device_region'))) {
               // $temp_values->where('region_id', session()->get('env_device_region'));
            }
        } else {
            $temp_values->whereIn('region_id', auth()->user()->regions->pluck('id')->toArray());
        }

        $temp_values = $temp_values->get();
        $oldDate = new \Carbon\Carbon();

        foreach($temp_values as &$temp_value) {
            if($temp_value->values->count() == 2) {
                $latest = $temp_value->values[0];
                $previous = $temp_value->values[1];
            } else {
                continue;
            }

            $temp_value->battery = batteryPercentage($latest->battery);
            $temp_value->temperature = $latest->temperature;
            $temp_value->old_temperature = $previous->temperature;
            $temp_value->humidity = $latest->humidity;
            $temp_value->old_humidity =$previous->humidity;

            $lastDate = new \Carbon\Carbon($latest->record_date);
            $temp_value->difference = $oldDate->diffInMinutes($lastDate);

            //Offline
            if($temp_value->difference > 10) {
                $temp_value->offline_time = $lastDate->format('d.m.Y H:i');
            }
            if($temp_value->temperature < $temp_value->temperature_min or $temp_value->temperature > $temp_value->temperature_max) {
                $this->setAlarm(true);
            }
        }

        return $temp_values;
    }

    /**
     * @return bool
     */
    public function getAlarm(): bool
    {
        return $this->alarm;
    }

    /**
     * @param bool $alarm
     */
    public function setAlarm(bool $alarm): void
    {
        $this->alarm = $alarm;
    }
}
