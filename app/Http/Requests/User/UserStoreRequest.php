<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'tenant_id' => 'required',
            'name' => 'required',
            'tcKimlikNo' => 'sometimes',
            'phone' => 'sometimes',
            'email' => ['required', 'unique:users,email,NULL,id,deleted_at,NULL'],
            'password' => ['required', 'min:6'],
            'role' => 'required',
            'isPanelUser' => 'sometimes',
            'active' => 'sometimes',
            'send_email_notification' => 'sometimes',
            'send_sms_notification' => 'sometimes',
            'region' => 'required'
        ];
    }

    public function attributes() {
        return [
            'tenant_id' => 'Kurum Adı',
            'name' => 'Kullanıcı Adı',
            'email' => 'E-posta',
            'password' => 'Parola',
            'role' => 'Yetki',
            'region' => 'Bölge'
        ];
    }
}
