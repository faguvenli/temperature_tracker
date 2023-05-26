<?php

namespace App\Http\Livewire;

use App\Models\EnvDeviceData;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EnvSummary extends Component
{
    public $temp_values, $device, $device_id, $recordCount;

    protected $listeners = [
        'setData' => 'set_data',
        'resetData' => 'reset_data'
    ];

    public function mount()
    {
        $this->set_data();
    }

    public function set_data($device_id = null)
    {
        $this->temp_values = [];
        $this->device_id = null;
        $this->device = null;
        if ($device_id) {
            $this->device_id = $device_id;
            $device = \App\Models\EnvDevice::find($device_id);

            $this->temp_values = EnvDeviceData::query()
                ->where('env_device_id', $device_id)
                ->whereBetween('temperature', [$device->temperature_min ?? 0, $device->temperature_max ?? 0])
                ->orderBy('record_date', 'desc')
                ->limit(10)
                ->get();

            $this->recordCount = $this->temp_values->count();

            if ($this->recordCount) {
                $this->device = $device;
            }


            $this->dispatchBrowserEvent('summary_loaded', ['result' => 'success', 'deviceType' => 'bag']);
        }
    }

    public function render()
    {
        return view('livewire.env-summary');
    }
}
