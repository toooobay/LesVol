<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Seeker;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class route_controller extends Controller
{
    public function homePage(Request $request)
    {
        $currentUser = session()->get('user');

        if (! $currentUser) {
            return redirect('/login');
        }

        $currentUserId = $currentUser->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);
        $search = $request->query('search');

        $baseActivitiesQuery = Activity::where('slot', '>', 0)
            ->where('is_done', false)
            ->whereDate('activity_date', '>=', now()->toDateString());

        $heroActivities = (clone $baseActivitiesQuery)
            ->orderBy('activity_date', 'asc')
            ->limit(6)
            ->get();

        $activitiesQuery = clone $baseActivitiesQuery;

        if ($search) {
            $activitiesQuery->where(function ($query) use ($search) {
                $query->where('activity_name', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $activities = $activitiesQuery
            ->orderBy('activity_date', 'asc')
            ->paginate(6)
            ->withQueryString();

        return view('home', compact('activities', 'heroActivities', 'isSeeker', 'search'));
    }

    public function loginPage()
    {
        return view('login');
    }

    public function landingPage()
    {
        return view('landing');
    }

    public function registerPage()
    {
        return view('register');
    }

    public function updateProfile(Request $request)
    {
        $currentUser = $request->session()->get('user');

        if (! $currentUser) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$currentUser->id,
            'phone' => 'required|string|max:20|unique:users,phone,'.$currentUser->id,
            'volunteer_type' => 'nullable|string|max:100',
            'date_of_birth' => 'nullable|date',
            'occupation' => 'nullable|string|max:255',
            'domicile' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $user = User::findOrFail($currentUser->id);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->volunteer_type = $validated['volunteer_type'] ?? null;
        $user->date_of_birth = $validated['date_of_birth'] ?? null;
        $user->occupation = $validated['occupation'] ?? null;
        $user->domicile = $validated['domicile'] ?? null;
        $user->bio = $validated['bio'] ?? null;

        if (! empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture_path = $path;
        }

        try {
            $user->save();
            $request->session()->put('user', $user->forSession());

            return redirect('/profile')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            report($e);

            return redirect()->back()->withErrors(['error' => 'Failed to save your profile. Please try again.'])->withInput();
        }
    }

    public function uploadActivityPage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);

        return view('upload-activity', compact('isSeeker'));
    }

    public function activityPage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);

        return view('activity', compact('isSeeker'));
    }

    public function beASeekerPage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);

        return view('be-a-seeker', compact('isSeeker'));
    }

    public function doneActivityPage(Request $request)
    {
        $search = $request->input('search');
        $doneType = $request->query('type', 'joined');

        $currentUserId = $request->session()->get('user')->id;
        $currentSeeker = Seeker::where('user_id', $currentUserId)->first();
        $isSeeker = ! is_null($currentSeeker);

        if ($isSeeker && $doneType === 'proposed') {
            $activities = Activity::with(['volunteers' => function ($query) use ($currentUserId) {
                $query->where('user_id', $currentUserId);
            }])
                ->where('seeker_id', $currentSeeker->id)
                ->where('is_done', true)
                ->when($search, function ($query) use ($search) {
                    return $query->where(function ($subQuery) use ($search) {
                        $subQuery->where('activity_name', 'like', '%'.$search.'%')
                            ->orWhere('location', 'like', '%'.$search.'%')
                            ->orWhere('description', 'like', '%'.$search.'%');
                    });
                })
                ->get();
        } else {
            $doneType = 'joined';

            $activities = Activity::with(['volunteers' => function ($query) use ($currentUserId) {
                $query->where('user_id', $currentUserId);
            }])
                ->where('is_done', true)
                ->whereHas('volunteers', function ($query) use ($currentUserId) {
                    $query->where('user_id', $currentUserId)
                        ->where('is_banned', false);
                })
                ->when($search, function ($query) use ($search) {
                    return $query->where(function ($subQuery) use ($search) {
                        $subQuery->where('activity_name', 'like', '%'.$search.'%')
                            ->orWhere('location', 'like', '%'.$search.'%')
                            ->orWhere('description', 'like', '%'.$search.'%');
                    });
                })
                ->get();
        }

        return view('done-activity', compact('activities', 'isSeeker', 'currentUserId', 'doneType', 'search'));
    }

    public function bannedActivitiesPage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);
        $search = $request->query('search');

        $activitiesQuery = Activity::whereHas('volunteers', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId)
                ->where('is_banned', true);
        });

        if ($search) {
            $activitiesQuery->where(function ($query) use ($search) {
                $query->where('activity_name', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $activities = $activitiesQuery->get();

        return view('banned-activities', compact('isSeeker', 'activities', 'search'));
    }

    public function myActivitiesPage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);
        $search = $request->query('search');

        $activitiesQuery = Activity::whereHas('volunteers', function ($query) use ($currentUserId) {
            $query->where('user_id', $currentUserId)
                ->where('is_banned', false);
        })
            ->where('is_done', false);

        if ($search) {
            $activitiesQuery->where(function ($query) use ($search) {
                $query->where('activity_name', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $activities = $activitiesQuery->get();

        return view('my-activities', compact('isSeeker', 'activities', 'search'));
    }

    public function optionsPage(Request $request, $id)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);
        $activity = Activity::with('seeker.user')->findOrFail($id);
        abort_unless($activity->isOwnedBy($currentUserId), 403);
        $volunteersCount = Volunteer::where('activity_id', $id)->count();

        $backUrl = $this->safeBackUrl($request);

        return view('options', compact('activity', 'volunteersCount', 'isSeeker', 'backUrl'));
    }

    public function participantsPage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);
        $activityId = $request->query('activity_id');

        if (! $activityId) {
            return redirect('/proposed-activities')->with('error', 'Activity not found.');
        }

        $activity = Activity::findOrFail($activityId);
        abort_unless($activity->isOwnedBy($currentUserId), 403);

        $volunteers = Volunteer::with('user')
            ->where('activity_id', $activityId)
            ->get();

        $volunteersCount = $volunteers->count();

        return view('participants', compact('activity', 'volunteers', 'volunteersCount', 'isSeeker'));
    }

    public function profilePage(Request $request, $id = null)
    {
        $currentUser = $request->session()->get('user');

        if (! $currentUser) {
            return redirect('/login');
        }

        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUser->id);

        if ($id) {
            $user = User::findOrFail($id);
        } else {
            $user = User::findOrFail($currentUser->id);
        }

        $isOwnProfile = $currentUser->id == $user->id;

        $backUrl = '/home';

        if ($request->query('back') === 'participants' && $request->query('activity_id')) {
            $backUrl = '/participants?activity_id='.$request->query('activity_id');
        }

        return view('profile', compact('user', 'isOwnProfile', 'backUrl', 'isSeeker'));
    }

    public function proposedActivitiesPage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);
        $search = $request->query('search');

        if (! $isSeeker) {
            return redirect('/')->with('error', 'You are not registered as a seeker.');
        }

        $activitiesQuery = Activity::where('seeker_id', '=', $isSeeker->id)
            ->where('is_done', false);

        if ($search) {
            $activitiesQuery->where(function ($query) use ($search) {
                $query->where('activity_name', 'like', '%'.$search.'%')
                    ->orWhere('location', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $activities = $activitiesQuery->get();

        return view('proposed-activities', compact('activities', 'isSeeker', 'search'));
    }

    public function registerActivityPage(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);
        $user = User::firstWhere('id', '=', $currentUserId);

        return view('register-activity', compact('activity', 'user', 'isSeeker'));
    }

    public function submitRegisterActivity(Request $request, $id)
    {
        $currentUser = $request->session()->get('user');

        if (! $currentUser) {
            return redirect('/login');
        }

        $currentUserId = $currentUser->id;

        $currentSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);

        try {
            DB::transaction(function () use ($id, $currentUserId, $currentSeeker) {
                $activity = Activity::lockForUpdate()->findOrFail($id);

                if ($activity->is_done) {
                    throw new \Exception('Sorry, this activity has already been completed.');
                }

                if ($activity->slot <= 0) {
                    throw new \Exception('Sorry, this activity is full.');
                }

                if ($currentSeeker && $activity->seeker_id == $currentSeeker->id) {
                    throw new \Exception('You cannot join your own activity.');
                }

                $existingVolunteer = Volunteer::where('user_id', $currentUserId)
                    ->where('activity_id', $id)
                    ->first();

                if ($existingVolunteer) {
                    throw new \Exception('You are already registered for this activity.');
                }

                Volunteer::create([
                    'is_banned' => 0,
                    'file_att_path' => null,
                    'user_id' => $currentUserId,
                    'activity_id' => $id,
                ]);

                $activity->slot = $activity->slot - 1;
                $activity->save();
            });

            return redirect()->back()->with('success', 'You are successfully registered!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function seeDetailsDonePage(Request $request, $id)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);

        $activity = Activity::with('seeker.user')->findOrFail($id);

        $volunteer = Volunteer::where('activity_id', $id)
            ->where('user_id', $currentUserId)
            ->first();

        $isJoined = $volunteer !== null;

        $backUrl = $this->safeBackUrl($request);

        return view('see-details-done', compact('activity', 'isSeeker', 'isJoined', 'volunteer', 'backUrl'));
    }

    public function seeDetailsPage($id, Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);

        $activity = Activity::with('seeker.user')->findOrFail($id);

        $volunteer = Volunteer::where('activity_id', $id)
            ->where('user_id', $currentUserId)
            ->first();

        $isJoined = $volunteer !== null;
        $backUrl = $this->safeBackUrl($request);

        return view('see-details', compact('activity', 'isSeeker', 'isJoined', 'volunteer', 'backUrl'));

    }

    public function editProfilePage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);
        $user = User::findOrFail($currentUserId);

        return view('edit-profile', compact('isSeeker', 'user'));
    }

    public function editPortfolioPage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);

        return view('edit-portfolio', compact('isSeeker'));
    }

    public function myPortfolioPage(Request $request)
    {
        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);

        $portfolioItems = Volunteer::where('user_id', $currentUserId)
            ->whereNotNull('file_att_path')
            ->where('is_banned', false)
            ->with('activity')
            ->paginate(10);

        return view('my-portfolio', compact('isSeeker', 'portfolioItems'));
    }

    public function viewPortfolioPage(Request $request)
    {

        $currentUserId = $request->session()->get('user')->id;
        $isSeeker = Seeker::firstWhere('user_id', '=', $currentUserId);

        $portfolioItems = Volunteer::where('user_id', $currentUserId)
            ->whereNotNull('file_att_path')
            ->where('is_banned', false)
            ->with('activity')
            ->get();

        return view('view-portfolio', compact('isSeeker', 'portfolioItems'));
    }

    private function safeBackUrl(Request $request): string
    {
        $back = $request->query('back', url()->previous());

        if (! is_string($back)) {
            return '/home';
        }

        $isLocalPath = str_starts_with($back, '/') && ! str_starts_with($back, '//');
        $isSameSite = $back === url('/') || str_starts_with($back, url('/').'/');

        return $isLocalPath || $isSameSite ? $back : '/home';
    }
}
