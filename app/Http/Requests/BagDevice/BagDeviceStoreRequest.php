<?php

namespace App\Http\Requests\BagDevice;

use Illuminate\Foundation\Http\FormRequest;

class BagDeviceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'region_id' => 'sometimes',
            'bag_device_type_id' => 'sometimes',
            'device_model' => 'sometimes',
            'device_mac' => 'sometimes',
            'device_location' => 'sometimes',
            'serial_number' => 'required',
            'temperature_calibration_trim' => 'sometimes',
            'temperature_max' => 'sometimes',
            'temperature_min' => 'sometimes',
        ];
    }

    public function attributes() {
        return [
            'serial_number' => 'Seri Numarası'
        ];
    }
}
