<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdatePasswordRequest;

class UpdatePasswordController extends Controller
{

    public function update(UpdatePasswordRequest $request, User $user)
    {
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('users.edit', $user->id)->with('status-password', 'Password actualizada!');
    }
}
