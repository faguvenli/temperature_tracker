<?php

namespace App\Http\Livewire;

use App\Models\BagTksGprs;
use Livewire\Component;

class BagSummary extends Component
{
    public $temp_values, $imei, $device, $recordCount;

    protected $listeners = [
        'setData' => 'set_data',
        'resetData' => 'reset_data'
    ];

    public function mount() {
        $this->set_data();
    }

    public function set_data($imei = null) {
        $this->temp_values = [];
        $this->imei = null;
        $this->device = null;
        if($imei) {
            $this->imei = $imei;
            $device = \App\Models\BagDevice::query()
                ->where('serial_number', $imei)
                ->first();

            $temp_values = BagTksGprs::query()
                ->where('imei', $imei)
                ->where(function($q) use ($device) {
                    $q->where('isi1', '>=', ($device->temperature_max??0))
                        ->orWhere('isi1', '<=', ($device->temperature_min??0));
                });

            $this->recordCount = $temp_values->count();

            $this->temp_values = $temp_values
                ->orderBy('date_time', 'desc')
                ->limit(10)
                ->get();

            if($this->recordCount) {
                $this->device = $device;
            }


            $this->dispatchBrowserEvent('summary_loaded', ['result' => 'success', 'deviceType' => 'bag']);
        }
    }

    public function render()
    {
        return view('livewire.bag-summary');
    }
}
