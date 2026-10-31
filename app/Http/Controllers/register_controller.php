<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class register_controller extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'dob' => 'required|date',
            'occupation' => 'required|string|max:255',
            'domicile' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
            'volunteer_type' => 'required',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'date_of_birth' => $validated['dob'],
            'occupation' => $validated['occupation'],
            'domicile' => $validated['domicile'],
            'password' => $validated['password'],
            'volunteer_type' => $validated['volunteer_type'],
        ]);

        return redirect('/')->with('success', 'Account created successfully!');
    }
}
