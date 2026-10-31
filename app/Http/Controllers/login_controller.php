<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class login_controller extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', '=', $validated['email'])->first();
        if ($user === null || ! Hash::check($validated['password'], $user->password)) {
            return back()->with('error', 'Error! Data is invalid!');
        }

        $request->session()->regenerate();
        $request->session()->put('user', $user->forSession());

        return redirect('/home')->with('success', 'Logged in!');
    }
}
