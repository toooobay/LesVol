<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Seeker;
use App\Models\Volunteer;
use Illuminate\Http\Request;

class activity_controller extends Controller
{
    public function uploadActivity(Request $request)
    {
        $validated = $request->validate([
            'activity_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',

            'activity_date' => 'required|date|after:today',
            'activity_time' => 'required',

            'slot' => 'required|integer|min:1',

            'open_reg_date' => 'required|date',
            'close_reg_date' => 'required|date|after:open_reg_date|before:activity_date',

            'requirements' => 'required|string',
            'description' => 'required|string',

            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'activity_name.required' => 'This field is required.',
            'location.required' => 'This field is required.',
            'activity_date.required' => 'This field is required.',
            'activity_time.required' => 'This field is required.',
            'slot.required' => 'This field is required.',
            'open_reg_date.required' => 'This field is required.',
            'close_reg_date.required' => 'This field is required.',
            'requirements.required' => 'This field is required.',
            'description.required' => 'This field is required.',
            'image.required' => 'This field is required.',

            'activity_date.after' => 'Activity date must be after today.',
            'slot.integer' => 'Slot must be a number.',
            'slot.min' => 'Slot must be at least 1.',
            'close_reg_date.after' => 'Close registration date must be after open registration date.',
            'close_reg_date.before' => 'Close registration date must be before the activity date.',
            'image.image' => 'Uploaded file must be an image.',
            'image.mimes' => 'Image must be in JPG, JPEG, or PNG format.',
            'image.max' => 'Image size must not be larger than 2MB.',
        ]);

        $currentUser = $request->session()->get('user');

        if (! $currentUser) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $currentSeeker = Seeker::firstWhere('user_id', '=', $currentUser->id);

        if (! $currentSeeker) {
            return redirect('/be-a-seeker')->with('error', 'You need to become a seeker before uploading an activity.');
        }

        $imagePath = $request->file('image')->store('activities', 'public');

        Activity::create([
            'activity_name' => $validated['activity_name'],
            'activity_date' => $validated['activity_date'],
            'activity_time' => $validated['activity_time'],
            'location' => $validated['location'],
            'description' => $validated['description'],
            'requirements' => $validated['requirements'],
            'open_reg_date' => $validated['open_reg_date'],
            'close_reg_date' => $validated['close_reg_date'],
            'image_path' => $imagePath,
            'slot' => $validated['slot'],
            'seeker_id' => $currentSeeker->id,
        ]);

        return redirect('/proposed-activities')->with('success', 'Activity uploaded successfully!');
    }

    public function deleteActivity(Request $request, $id)
    {
        $activity = Activity::withCount('volunteers')->findOrFail($id);
        abort_unless($activity->isOwnedBy($request->session()->get('user')->id), 403);

        if ($activity->volunteers_count > 0) {
            return redirect('/proposed-activities')
                ->with('error', 'Activity cannot be deleted because at least one volunteer has joined.');
        }

        $activity->delete();

        return redirect('/proposed-activities')
            ->with('success', 'Activity deleted successfully!');
    }

    public function markDoneActivity(Request $request, $id)
    {
        $activity = Activity::findOrFail($id);
        abort_unless($activity->isOwnedBy($request->session()->get('user')->id), 403);

        $activity->is_done = true;
        $activity->save();

        return redirect('/proposed-activities')->with('success', 'Activity marked as done!');
    }

    public function uploadAttendance(Request $request, $id)
    {
        $request->validate([
            'attendance_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $currentUserId = $request->session()->get('user')->id;

        $volunteer = Volunteer::where('activity_id', $id)
            ->where('user_id', $currentUserId)
            ->firstOrFail();

        if ($volunteer->is_banned) {
            return redirect()->back()->with('error', 'You cannot upload attendance because you have been banned from this activity.');
        }

        $activity = Activity::findOrFail($id);

        if (! $activity->is_done) {
            return redirect()->back()->with('error', 'Attendance can only be uploaded after the activity is marked as done.');
        }

        if ($request->hasFile('attendance_photo')) {
            $path = $request->file('attendance_photo')->store('attendance_proofs', 'public');
            $volunteer->file_att_path = $path;
            $volunteer->save();
        }

        return redirect()->back()->with('success', 'Attendance proof uploaded successfully!');
    }

    public function updateDescription(Request $request, $id)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:5000',
        ]);

        $currentUserId = $request->session()->get('user')->id;
        $currentSeeker = Seeker::where('user_id', $currentUserId)->firstOrFail();

        $activity = Activity::where('id', $id)
            ->where('seeker_id', $currentSeeker->id)
            ->firstOrFail();

        $activity->description = $validated['description'];
        $activity->save();

        return redirect('/options/'.$id)->with('success', 'Description updated successfully!');
    }

    public function toggleBan(Request $request, $id)
    {
        $volunteer = Volunteer::with('activity')->findOrFail($id);
        abort_unless($volunteer->activity->isOwnedBy($request->session()->get('user')->id), 403);

        $volunteer->is_banned = ! $volunteer->is_banned;
        $volunteer->save();

        return redirect()->back()->with('success', 'Volunteer status updated successfully!');
    }
}
