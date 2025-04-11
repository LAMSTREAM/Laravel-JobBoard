<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobPostController;

Route::get('/', function () {
    // If user is logged in, redirect to job posts index
    if (auth()->check()) {
        return redirect()->route('job-posts.index');
    }

    // If user is not logged in, redirect to login page
    return view('auth.login');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Job Posts
    Route::resource('job-posts', JobPostController::class);
    // Custom route for toggling interest
    Route::post('/job-posts/{jobPost}/toggle-interest', [JobPostController::class, 'toggleInterest'])->name('job-posts.toggle-interest');

});

require __DIR__.'/auth.php';
