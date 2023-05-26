<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'name' => ['required'],
            'phone' => ['sometimes'],
            'tcKimlikNo' => ['sometimes'],
            'email' => [
                'required',
                Rule::unique('users')->ignore(auth()->user())
            ],
            'password' => ['nullable', 'min:6'],
        ];
    }

    public function attributes() {
        return [
            'name' => __('Name'),
            'email' => __('E-mail'),
            'password' => __('Password')
        ];
    }
}
