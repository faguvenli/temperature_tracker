<?php

namespace App\Http\Actions;

use App\Models\User;

class UserAction
{
    public function store($data)
    {
        $data['active'] = $data['active'] ?? false;
        $data['isPanelUser'] = $data['isPanelUser'] ?? false;
        $data['send_email_notification'] = $data['send_email_notification'] ?? false;
        $data['send_sms_notification'] = $data['send_sms_notification'] ?? false;

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $user->assignRole($data['role']);
        $user->regions()->sync($data['region']);
        session()->flash('success', 'kaydedildi');
        return redirect()->route('users.index');
    }

    public function update($user, $data)
    {
        if (is_null($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $data['active'] = $data['active'] ?? false;
        $data['isPanelUser'] = $data['isPanelUser'] ?? false;
        $data['send_email_notification'] = $data['send_email_notification'] ?? false;
        $data['send_sms_notification'] = $data['send_sms_notification'] ?? false;

        if ($user->phone != $data['phone']) {
            $data['phoneNumberVerified'] = false;
        }

        $user->update($data);

        $user->syncRoles($data['role']);
        $user->regions()->sync($data['region']);

        session()->flash('success', 'güncellendi');
        return redirect()->route('users.edit', $user);
    }
}
