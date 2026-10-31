<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Seeker;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class user_controller extends Controller
{
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }

    public function deleteAccount(Request $request, $id)
    {
        $currentUser = $request->session()->get('user');

        if (! $currentUser || $currentUser->id != $id) {
            return redirect('/home')->with('error', 'Unauthorized action.');
        }

        $user = User::find($id);
        if ($user) {
            $hasJoinedActivities = Volunteer::where('user_id', $id)
                ->where('is_banned', false)
                ->whereHas('activity', function ($query) {
                    $query->where('is_done', false);
                })
                ->exists();

            $hasProposedActivities = false;
            $seeker = Seeker::where('user_id', $id)->first();
            if ($seeker) {
                $hasProposedActivities = Activity::where('seeker_id', $seeker->id)
                    ->where('is_done', false)
                    ->exists();
            }

            if ($hasJoinedActivities && $hasProposedActivities) {
                return redirect()->back()->with('error', 'Cannot delete account. You still have active joined and proposed activities.');
            } elseif ($hasJoinedActivities) {
                return redirect()->back()->with('error', 'Cannot delete account. You still have active joined activities.');
            } elseif ($hasProposedActivities) {
                return redirect()->back()->with('error', 'Cannot delete account. You still have active proposed activities.');
            }

            $user->delete();
        }

        $request->session()->forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}
