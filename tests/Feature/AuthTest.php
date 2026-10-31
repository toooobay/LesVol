<?php

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

beforeEach(fn () => $this->withoutMiddleware(ValidateCsrfToken::class));

test('registration stores a hashed password', function () {
    $this->post('/user-register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'phone' => '081234567890',
        'dob' => '2000-01-01',
        'occupation' => 'Student',
        'domicile' => 'Jakarta',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'terms' => 'on',
        'volunteer_type' => 'Education',
    ])->assertRedirect('/');

    $stored = DB::table('users')->where('email', 'test@example.com')->value('password');

    expect($stored)->not->toBe('password123')
        ->and(Hash::check('password123', $stored))->toBeTrue();
});

test('users can log in with the correct password', function () {
    $user = User::factory()->create(['password' => 'password123']);

    $this->post('/user-login', ['email' => $user->email, 'password' => 'password123'])
        ->assertRedirect('/home');
});

test('users cannot log in with the wrong password', function () {
    $user = User::factory()->create(['password' => 'password123']);

    $this->post('/user-login', ['email' => $user->email, 'password' => 'wrong-password'])
        ->assertSessionHas('error');

    expect(session()->has('user'))->toBeFalse();
});

test('the session does not hold the password', function () {
    $user = User::factory()->create(['password' => 'password123']);

    $this->post('/user-login', ['email' => $user->email, 'password' => 'password123']);

    expect(session('user')->getAttributes())->not->toHaveKey('password');
});

test('users can log in after changing their password', function () {
    $user = User::factory()->create(['password' => 'password123']);

    $this->withSession(['user' => $user->forSession()])->patch('/update-profile', [
        'name' => $user->name,
        'email' => $user->email,
        'phone' => $user->phone,
        'password' => 'new-password123',
        'password_confirmation' => 'new-password123',
    ])->assertRedirect('/profile');

    $this->post('/logout');

    $this->post('/user-login', ['email' => $user->email, 'password' => 'new-password123'])
        ->assertRedirect('/home');
});

test('logout requires a post request', function () {
    $user = User::factory()->create();

    $this->withSession(['user' => $user->forSession()])->get('/logout')->assertMethodNotAllowed();
});
