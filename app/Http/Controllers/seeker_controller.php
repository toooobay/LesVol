<?php

namespace App\Http\Controllers;

use App\Models\Seeker;
use Illuminate\Http\Request;

class seeker_controller extends Controller
{
    public function registerSeeker(Request $request)
    {

        $request->validate([
            'identity_card' => 'required|image|mimes:png,jpg,jpeg|max:10240',
        ]);

        $userId = $request->session()->get('user')->id;

        if (Seeker::where('user_id', $userId)->exists()) {
            return redirect('/be-a-seeker')->with('error', 'You are already a seeker.');
        }

        if ($request->hasFile('identity_card')) {
            $path = $request->file('identity_card')->store('ktp', 'local');

            Seeker::create([
                'file_ktp_path' => $path,
                'user_id' => $userId,
            ]);

            return redirect('/be-a-seeker')->with('success', 'Welcome Seeker!');
        }
    }
}
