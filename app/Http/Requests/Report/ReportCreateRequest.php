<?php

namespace App\Http\Requests\Report;

use Illuminate\Foundation\Http\FormRequest;

class ReportCreateRequest extends FormRequest
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
            "date_from" => "sometimes",
            "date_to" => "sometimes",
            "device_type" => "required",
            "report_type" => "required"
        ];
    }

    public function attributes() {
        return [
            'device_type' => 'Cihaz Tipi',
            'report_type' => 'Rapor Tipi'
        ];
    }
}
