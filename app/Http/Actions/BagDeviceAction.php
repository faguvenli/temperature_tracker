<?php

namespace App\Http\Actions;
use App\Models\BagDevice;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class BagDeviceAction
{
    public function store($data) {

        BagDevice::create($data);

        session()->flash('success', 'kaydedildi');
        return redirect()->route('bag-devices.index');
    }

    public function update($bagDevice, $data) {

        $bagDevice->update($data);

        session()->flash('success', 'güncellendi');
        return redirect()->route('bag-devices.edit', $bagDevice);
    }

    public function refreshFeed() {
        $regionDatabase = Config::get('database.connections.mysql.database');
        $temp_values = BagDevice::query()
            ->with('values')
            ->select(
                'bag_devices.device_location',
                'bag_devices.device_model',
                'bag_devices.serial_number',
                DB::raw('ifnull(bag_devices.temperature_max, 0) as temperature_max'),
                DB::raw('ifnull(bag_devices.temperature_min, 0) as temperature_min'),
                DB::raw('ifnull(regions.name, "Bölge Seçilmemiş") as region_name')
            )
            ->leftJoin($regionDatabase.'.regions as regions', 'regions.id', '=', 'bag_devices.region_id')
            ->orderBy('bag_devices.device_location');

        if(!auth()->user()->isSuperAdmin) {
           // $temp_values->whereIn('region_id', auth()->user()->regions->pluck('id')->toArray());
        } elseif(session()->get('bag_device_region') && !is_null(session()->get('bag_device_region'))) {
           // $temp_values->where('region_id', session()->get('bag_device_region'));
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

            $temp_value->batarya = $latest->batarya;
            $temp_value->isi1 = $latest->isi1;
            $temp_value->old_value = $previous->isi1;

            $lastDate = new \Carbon\Carbon($latest->date_time);
            $temp_value->difference = $oldDate->diffInMinutes($lastDate);

            //Offline
            if($temp_value->difference > 10) {
                $temp_value->offline_time = $lastDate->format('d.m.Y H:i');
            }
        }
        return $temp_values;
    }
}
