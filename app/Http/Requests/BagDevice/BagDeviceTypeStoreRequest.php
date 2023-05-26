<?php

namespace App\Http\Requests\BagDevice;

use Illuminate\Foundation\Http\FormRequest;

class BagDeviceTypeStoreRequest extends FormRequest
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
            'description' => 'sometimes',
        ];
    }

    public function attributes() {
        return [
            'name' => 'Cihaz Tipi'
        ];
    }
}
