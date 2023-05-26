<?php

namespace App\Exports;

use App\Models\BagTksGprs;
use App\Models\EnvDeviceData;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class ReportExport implements FromQuery, ShouldQueue
{
    use Exportable;

    public $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function query()
    {
        Config::set('database.connections.tenant.database', $this->data['tenantDatabase']);

        if($this->data['device_type'] === "Çevre Cihazları") {
            $temp_values = EnvDeviceData::query()
                ->select(
                    'env_device_data.record_date',
                    'env_devices.name',
                    'env_devices.temperature_max',
                    'env_devices.temperature_min',

                    DB::raw('ifnull(regions.name, "Bölge Seçilmemiş") as region_name'),

                    'env_device_data.temperature',
                    'env_device_data.humidity',
                    'env_device_data.battery'
                )
                ->leftJoin('env_devices', 'env_devices.id', '=', 'env_device_data.env_device_id')
                ->leftJoin('iot_main.regions as regions', 'regions.id', '=', 'env_devices.region_id')
                ->where('env_devices.confirmed', 1)
                ->whereBetween('env_device_data.record_date', [$this->data['dateFrom'], $this->data['dateTo']]);


            if ($this->data['report_type'] == "Anomali Raporu") {
                $temp_values = $temp_values->where(function ($q) {
                    $q->whereColumn('env_device_data.temperature', '<', 'env_devices.temperature_min')
                        ->orWhereColumn('env_device_data.temperature', '>', 'env_devices.temperature_max');
                });
            }

            return $temp_values->orderBy('env_device_data.record_date', 'desc');

        } else {
            $temp_values = BagTksGprs::query()
                ->select(
                    'bag_devices.serial_number as name',
                    'bag_devices.temperature_max',
                    'bag_devices.temperature_min',

                    DB::raw('ifnull(regions.name, "Bölge Seçilmemiş") as region_name'),

                    'bag_tks_gprs.date_time as record_date',
                    'bag_tks_gprs.isi1 as temperature',
                    'bag_tks_gprs.batarya as battery'
                )
                ->leftJoin('bag_devices', 'bag_devices.serial_number', '=', 'bag_tks_gprs.imei')
                ->leftJoin('iot_main.regions as regions', 'regions.id', '=', 'bag_devices.region_id')
                ->whereBetween('bag_tks_gprs.date_time', [$this->data['dateFrom'], $this->data['dateTo']]);

            if($this->data['report_type'] == "Anomali Raporu") {
                $temp_values = $temp_values->where(function($q) {
                    $q->whereColumn('bag_tks_gprs.isi1', '<', 'bag_devices.temperature_min')
                        ->orWhereColumn('bag_tks_gprs.isi1', '>', 'bag_devices.temperature_max');
                });
            }

            return $temp_values->orderBy('bag_tks_gprs.date_time', 'desc');
        }
    }
}
