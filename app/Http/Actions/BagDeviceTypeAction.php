<?php

namespace App\Http\Actions;
use App\Models\BagDeviceType;

class BagDeviceTypeAction
{
    public function store($data) {

        BagDeviceType::create($data);

        session()->flash('success', 'kaydedildi');
        return redirect()->route('bag-device-types.index');
    }

    public function update($bagDeviceType, $data) {

        $bagDeviceType->update($data);

        session()->flash('success', 'güncellendi');
        return redirect()->route('bag-device-types.edit', $bagDeviceType);
    }
}
