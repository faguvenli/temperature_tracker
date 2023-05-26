<?php

if (!function_exists('set_numeric')) {
    function set_numeric($value)
    {
        $value = $value ?? 0;
        if (!is_numeric($value)) {
            $value = 0;
        }
        return $value;
    }
}

if (!function_exists('getTypes')) {
    function getTypes(array $types): array
    {
        $result = [];
        foreach ($types as $type) {
            $newType = new \stdClass();
            $newType->id = $type['id'] ?? $type;
            $newType->name = $type['name'] ?? $type;
            $result[] = $newType;
        }
        return $result;
    }
}

if (!function_exists('money')) {
    /**
     * Instance of money class.
     *
     * @param mixed $amount
     *
     */
    function money($amount): string
    {
        return number_format($amount, 2, ',', '.');
    }
}

if (!function_exists('getList')) {
    function getList($request, $model): \Illuminate\Http\JsonResponse
    {
        $term = $request->input('q');

        $items = $model::select('name', 'id')->orderBy('name');
        if (!empty($term)) {
            $items->where('name', 'like', "%$term%");
        }
        $items = $items->get()->map(function ($data) {
            return [
                'id' => $data->id,
                'text' => $data->name
            ];
        });

        return response()->json($items);
    }
}

if (!function_exists('batteryPercentage')) {
    function batteryPercentage($level)
    {
        $battery_status = null;
        if ($level <= 2400) {
            $battery_status = 'Kapatılacak';
        }
        if ($level > 2400 && $level <= 2500) {
            $battery_status = "Pili Değiştirin";
        }
        if ($level > 2500 && $level <= 2600) {
            $battery_status = 10;
        }
        if ($level > 2600 && $level <= 2650) {
            $battery_status = 20;
        }
        if ($level > 2650 && $level <= 2700) {
            $battery_status = 30;
        }
        if ($level > 2700 && $level <= 2800) {
            $battery_status = 40;
        }
        if ($level > 2800 && $level <= 2900) {
            $battery_status = 50;
        }
        if ($level > 2900 && $level <= 2950) {
            $battery_status = 60;
        }
        if ($level > 2950 && $level <= 3000) {
            $battery_status = 70;
        }
        if ($level > 3000 && $level <= 3050) {
            $battery_status = 80;
        }
        if ($level > 3050 && $level <= 3100) {
            $battery_status = 90;
        }
        if ($level > 3100 && $level <= 3600) {
            $battery_status = 100;
        }
        if ($level > 3600 && $level <= 3800) {
            $battery_status = "Pilde Sorun Var";
        }
        if ($level > 3800) {
            $battery_status = "Aşırı Güç";
        }
        return $battery_status;
    }
}

if (!function_exists('encodingFixer')) {
    function encodingFixer($text)
    {
        $bad = ["ü", "ı", "ö", "ğ", "ç", "ş", "Ü", "İ", "Ö", "Ğ", "Ç", "Ş"];
        $good = ["u", "i", "o", "g", "c", "s", "U", "I", "O", "G", "C", "S"];
        return str_replace($bad, $good, $text);
    }
}
