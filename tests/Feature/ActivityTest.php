<?php

use App\Models\Activity;
use App\Models\Seeker;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function activityFor(User $owner): Activity
{
    $seeker = Seeker::create(['file_ktp_path' => 'ktp/card.jpg', 'user_id' => $owner->id]);

    return Activity::create([
        'activity_name' => 'Beach Cleanup',
        'activity_date' => now()->addDays(10),
        'activity_time' => '10:00',
        'location' => 'Jakarta',
        'description' => 'Description',
        'requirements' => 'Requirements',
        'open_reg_date' => now(),
        'close_reg_date' => now()->addDays(5),
        'image_path' => 'activities/image.png',
        'slot' => 3,
        'seeker_id' => $seeker->id,
    ]);
}

function loginAs(User $user)
{
    return test()->withSession(['user' => $user->forSession()]);
}

beforeEach(function () {
    $this->withoutMiddleware(ValidateCsrfToken::class);
    $this->owner = User::factory()->create();
    $this->other = User::factory()->create();
    $this->activity = activityFor($this->owner);
});

test('only the owner can delete an activity', function () {
    loginAs($this->other)->delete("/delete-activity/{$this->activity->id}")->assertForbidden();
    expect(Activity::find($this->activity->id))->not->toBeNull();

    loginAs($this->owner)->delete("/delete-activity/{$this->activity->id}")->assertRedirect();
    expect(Activity::find($this->activity->id))->toBeNull();
});

test('only the owner can mark an activity as done', function () {
    loginAs($this->other)->post("/mark-done-activity/{$this->activity->id}")->assertForbidden();
    expect((bool) $this->activity->fresh()->is_done)->toBeFalse();

    loginAs($this->owner)->post("/mark-done-activity/{$this->activity->id}")->assertRedirect();
    expect((bool) $this->activity->fresh()->is_done)->toBeTrue();
});

test('activity changes cannot be triggered by a get request', function () {
    loginAs($this->owner)->get("/delete-activity/{$this->activity->id}")->assertMethodNotAllowed();
    loginAs($this->owner)->get("/mark-done-activity/{$this->activity->id}")->assertMethodNotAllowed();
});

test('only the owner can ban a volunteer', function () {
    $volunteer = Volunteer::create([
        'user_id' => User::factory()->create()->id,
        'activity_id' => $this->activity->id,
        'is_banned' => 0,
    ]);

    loginAs($this->other)->post("/volunteer/{$volunteer->id}/toggle-ban")->assertForbidden();
    expect((bool) $volunteer->fresh()->is_banned)->toBeFalse();

    loginAs($this->owner)->post("/volunteer/{$volunteer->id}/toggle-ban")->assertRedirect();
    expect((bool) $volunteer->fresh()->is_banned)->toBeTrue();
});

test('only the owner can open the manage pages', function (string $path) {
    $url = str_replace('{id}', $this->activity->id, $path);

    loginAs($this->other)->get($url)->assertForbidden();
    loginAs($this->owner)->get($url)->assertOk();
})->with(['/participants?activity_id={id}', '/options/{id}']);

test('identity cards are stored privately', function () {
    Storage::fake('public');
    Storage::fake('local');

    loginAs($this->other)->post('/register-seeker', [
        'identity_card' => UploadedFile::fake()->image('ktp.jpg'),
    ])->assertRedirect('/be-a-seeker');

    expect(Storage::disk('public')->allFiles())->toBeEmpty()
        ->and(Storage::disk('local')->allFiles('ktp'))->toHaveCount(1);
});

test('back links cannot point to another site', function () {
    loginAs($this->other)
        ->get("/see-details/{$this->activity->id}?back=".urlencode('https://evil.example'))
        ->assertOk()
        ->assertDontSee('evil.example');
});

test('signed in pages load', function (string $path) {
    loginAs($this->owner)->get($path)->assertOk();
})->with([
    '/home', '/profile', '/activity', '/my-activities', '/done-activity',
    '/banned-activities', '/proposed-activities', '/my-portfolio', '/view-portfolio',
    '/edit-portfolio', '/edit-profile', '/be-a-seeker', '/upload-activity',
]);
