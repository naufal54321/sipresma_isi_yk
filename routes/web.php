<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::middleware(['auth', 'role:Admin'])->group(function () {

    Route::get('/users/{user}/edit',
        [UserController::class, 'edit'])
        ->name('users.edit');

    Route::patch('/users/{user}',
        [UserController::class, 'update'])
        ->name('users.update');

        Route::delete('/users/{user}',
    [UserController::class, 'destroy'])
    ->name('users.destroy');

    Route::get('/users/create',
    [UserController::class, 'create'])
    ->name('users.create');

Route::post('/users',
    [UserController::class, 'store'])
    ->name('users.store');

});

use App\Models\User;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| ADMIN ONLY
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])->group(function () {

    Route::get('/admin', function () {

        $users = User::latest()->get();

        return view('admin.dashboard', compact('users'));

    })->name('admin.dashboard');

});

require __DIR__.'/auth.php';