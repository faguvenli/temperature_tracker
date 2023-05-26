<?php

namespace App\Http\Requests\DataCard;

use Illuminate\Foundation\Http\FormRequest;

class DataCardUpdateRequest extends FormRequest
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
            'GSMID' => 'required',
            'SIMID' => 'sometimes',
            'PIN1' => 'sometimes',
            'PIN2' => 'sometimes',
            'PUK1' => 'sometimes',
            'PUK2' => 'sometimes',
            'IMEI' => 'sometimes',
        ];
    }

    public function attributes() {
        return [
            'GSMID' => 'Gsm ID',
        ];
    }
}
