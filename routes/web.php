<?php

use App\Http\Controllers\activity_controller;
use App\Http\Controllers\login_controller;
use App\Http\Controllers\register_controller;
use App\Http\Controllers\route_controller;
use App\Http\Controllers\seeker_controller;
use App\Http\Controllers\user_controller;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

// Frontend Route URL (Tanpa Middleware)
Route::get('/', [route_controller::class, 'landingPage']);
Route::get('/register', [route_controller::class, 'registerPage']);
Route::get('/login', [route_controller::class, 'loginPage']);

// Backend Route URL (Tanpa Middleware)
Route::post('/user-register', [register_controller::class, 'register']);
Route::post('/user-login', [login_controller::class, 'login'])->middleware('throttle:6,1');

Route::middleware([AuthMiddleware::class])->group(function () {
    // Frontend Route URL (Dengan Middleware)
    Route::get('/home', [route_controller::class, 'homePage']);
    Route::get('/upload-activity', [route_controller::class, 'uploadActivityPage']);
    Route::get('/activity', [route_controller::class, 'activityPage']);
    Route::get('/be-a-seeker', [route_controller::class, 'beASeekerPage']);
    Route::get('/done-activity', [route_controller::class, 'doneActivityPage']);
    Route::get('/banned-activities', [route_controller::class, 'bannedActivitiesPage'])->name('banned-activities');
    Route::get('/my-activities', [route_controller::class, 'myActivitiesPage']);
    Route::get('/options/{id}', [route_controller::class, 'optionsPage']);
    Route::get('/participants', [route_controller::class, 'participantsPage']);
    Route::get('/profile', [route_controller::class, 'profilePage']);
    Route::get('/proposed-activities', [route_controller::class, 'proposedActivitiesPage']);
    Route::get('/register-activity/{id}', [route_controller::class, 'registerActivityPage']);
    Route::get('/see-details-done/{id}', [route_controller::class, 'seeDetailsDonePage'])->name('see-details-done');
    Route::get('/see-details/{id}', [route_controller::class, 'seeDetailsPage'])->name('see-details');
    Route::get('/edit-profile', [route_controller::class, 'editProfilePage']);
    Route::get('/edit-portfolio', [route_controller::class, 'editPortfolioPage']);
    Route::get('/view-portfolio', [route_controller::class, 'viewPortfolioPage']);
    Route::get('/my-portfolio', [route_controller::class, 'myPortfolioPage']);
    Route::get('/profile/{id}', [route_controller::class, 'profilePage']);

    // Backend Route URL (Dengan Middleware)
    Route::post('/register-seeker', [seeker_controller::class, 'registerSeeker'])->name('seeker.register');
    Route::post('/upload-activity', [activity_controller::class, 'uploadActivity'])->name('activity.upload');
    Route::patch('/update-profile', [route_controller::class, 'updateProfile'])->name('profile.update');
    Route::delete('/delete-activity/{id}', [activity_controller::class, 'deleteActivity'])->name('activity.delete');
    Route::post('/mark-done-activity/{id}', [activity_controller::class, 'markDoneActivity'])->name('activity.mark-done');
    Route::post('/activity/{id}/upload-attendance', [activity_controller::class, 'uploadAttendance'])->name('activity.upload-attendance');
    Route::post('/register-activity/{id}', [route_controller::class, 'submitRegisterActivity'])->name('activity.register');
    Route::post('/activity/{id}/update-description', [activity_controller::class, 'updateDescription'])->name('activity.update-description');
    Route::post('/volunteer/{id}/toggle-ban', [activity_controller::class, 'toggleBan'])->name('volunteer.toggle-ban');
    Route::post('/logout', [user_controller::class, 'logout'])->name('user.logout');
    Route::delete('users/{id}', [user_controller::class, 'deleteAccount'])->name('user.delete');
});
