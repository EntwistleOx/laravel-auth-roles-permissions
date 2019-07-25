<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UpdatePasswordController extends Controller
{
    public function update(Request $request, User $user)
    {
        $attributes = $request->validate([
            'password' => 'required|confirmed'
        ]);
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('users.edit', $user->id)->with('status', 'Password actualizada!');
    }
}
