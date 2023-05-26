<?php

namespace App\Http\Actions;
use App\Models\Region;

class RegionAction
{
    public function store($data) {

        $data['tenant_id'] = auth()->user()->tenant_id;

        Region::create($data);

        session()->flash('success', 'kaydedildi');
        return redirect()->route('regions.index');
    }

    public function update($region, $data) {

        $region->update($data);

        session()->flash('success', 'güncellendi');
        return redirect()->route('regions.edit', $region);
    }
}
