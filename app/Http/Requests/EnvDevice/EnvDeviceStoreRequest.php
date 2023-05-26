<?php

namespace App\Http\Requests\EnvDevice;

use Illuminate\Foundation\Http\FormRequest;

class EnvDeviceStoreRequest extends FormRequest
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
            'name' => 'required',
            'device_mac' => 'required',
            'confirmed' => 'required',
            'device_type' => 'required',
            'alarm_active' => 'sometimes',
            'temperature_calibration_trim' => 'sometimes',
            'humidity_calibration_trim' => 'sometimes',
            'temperature_max' => 'sometimes',
            'temperature_min' => 'sometimes',
            'humidity_max' => 'sometimes',
            'humidity_min' => 'sometimes',
            'region_id' => 'sometimes'
        ];
    }
}
