<?php

namespace App\Http\Actions;
use App\Models\DataCard;

class DataCardAction
{
    public function store($data) {

        DataCard::create($data);

        session()->flash('success', 'kaydedildi');
        return redirect()->route('data-cards.index');
    }

    public function update($dataCard, $data) {

        $dataCard->update($data);

        session()->flash('success', 'güncellendi');
        return redirect()->route('data-cards.edit', $dataCard);
    }
}
