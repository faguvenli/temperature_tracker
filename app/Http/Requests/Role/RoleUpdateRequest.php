<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleUpdateRequest extends FormRequest
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
            'name' => ['required',
                Rule::unique('roles')->ignore($this->role)],
            'permissions' => 'required|array|min:1'
        ];
    }

    public function attributes() {
        return [
            'name' => 'Yetki Adı',
            'permissions' => 'İzin',
        ];
    }
}
