<?php

namespace App\Http\Services;

use App\Exports\ReportExport;
use App\Models\BagTksGprs;
use App\Models\EnvDeviceData;
use App\Models\Report;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public $data;
    public $message;
    public $status;
    public $dateFrom;
    public $dateTo;

    private $regionDatabase;

    public function __construct($data) {
        $this->data = $data;
    }

    public function getResults() {

        $this->dateFrom = \Carbon\Carbon::parse($this->data['date_from'])->format('Y-m-d 00:00:00');
        $this->dateTo = \Carbon\Carbon::parse($this->data['date_to'])->format('Y-m-d 23:59:59');
        $this->regionDatabase = Config::get('database.connections.mysql.database');

        $temp_values_count = $this->getTempValues();

        if($temp_values_count > 0) {
            $excelData = [
                'dateFrom' => $this->dateFrom,
                'dateTo' => $this->dateTo,
                'device_type' => $this->data['device_type'],
                'report_type' => $this->data['report_type'],
                'tenantDatabase' => auth()->user()->tenant->database
            ];

            $storage_folder = auth()->user()->tenant_id ?? 'default';
            $file_name = 'report-' . date('dmY-His') . '.xlsx';

            (new ReportExport($excelData))->store($storage_folder . DIRECTORY_SEPARATOR . $file_name, 'public_disk');

            Report::create([
                'user_id' => auth()->id(),
                'description' => $this->getDescription(),
                'name' => $file_name
            ]);

            $this->setStatus('success');

        } else {
            $this->setStatus('fail');
            $this->setMessage('Raporlanacak sonuç bulunamadı.');
        }
        return [
            'message' => $this->message,
            'status' => $this->status
        ];
    }

    private function getDescription() {
        $start = \Carbon\Carbon::parse($this->dateFrom)->format('d.m.Y');
        $to = \Carbon\Carbon::parse($this->dateTo)->format('d.m.Y');

        return $start." - ".$to." arası ". $this->data['device_type']." ".$this->data['report_type'];
    }

    private function getTempValues() {
        switch ($this->data['device_type']) {
            case "Çevre Cihazları":
            default:
                $temp_values = $this->getEnvDeviceResults();
                break;
            case "Çanta Cihazları":
                $temp_values = $this->getBagDeviceResults();
                break;
        }
        return $temp_values;
    }

    private function getEnvDeviceResults() {
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
            ->leftJoin($this->regionDatabase.'.regions as regions', 'regions.id', '=', 'env_devices.region_id')
            ->where('env_devices.confirmed', 1)
            ->whereBetween('env_device_data.record_date', [$this->dateFrom, $this->dateTo]);


        if($this->data['report_type'] == "Anomali Raporu") {
            $temp_values = $temp_values->where(function($q) {
                $q->whereColumn('env_device_data.temperature', '<', 'env_devices.temperature_min')
                    ->orWhereColumn('env_device_data.temperature', '>', 'env_devices.temperature_max');
            });
        }

        return $temp_values->orderBy('env_device_data.record_date', 'desc')->count();
    }

    private function getBagDeviceResults() {
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
            ->leftJoin($this->regionDatabase.'.regions as regions', 'regions.id', '=', 'bag_devices.region_id')
            ->whereBetween('bag_tks_gprs.date_time', [$this->dateFrom, $this->dateTo]);

        if($this->data['report_type'] == "Anomali Raporu") {
            $temp_values = $temp_values->where(function($q) {
                $q->whereColumn('bag_tks_gprs.isi1', '<', 'bag_devices.temperature_min')
                    ->orWhereColumn('bag_tks_gprs.isi1', '>', 'bag_devices.temperature_max');
            });
        }

        return $temp_values->orderBy('bag_tks_gprs.date_time', 'desc')->count();
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }
}
