<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Models\User;

class ProfileController extends Controller
{
    public function show() {
        $user = auth()->user();
        return view('admin.profile.update', compact('user'));
    }

    public function edit() {
        $user = auth()->user();
        return view('admin.profile.update', compact('user'));
    }

    public function update(ProfileUpdateRequest $request, User $user) {
        $user = auth()->user();
        $data = $request->validated();

        if(is_null($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        if ($user->phone != $data['phone']) {
            $data['phoneNumberVerified'] = false;
        }

        $user->update($data);
        return redirect()->route('profile.show', $user->id);
    }
}
