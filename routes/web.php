<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\RpkController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DosenKegiatanController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE USER
|--------------------------------------------------------------------------
*/

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
| ADMIN ONLY (FULL AJAX SIPRESMA)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])->group(function () {

    /*
    | Dashboard Admin
    */
    Route::get('/admin', function () {

        $users = User::latest()->get();

        return view('admin.dashboard', compact('users'));

    })->name('admin.dashboard');


    /*
    | USERS CRUD (FULL REST API - AJAX READY)
    */
    Route::resource('users', UserController::class);


    /*
    | ROLE MANAGEMENT
    */
    Route::post('/users/{user}/role', [UserRoleController::class, 'update'])
        ->name('users.role.update');

});

Route::middleware(['auth', 'role:Mahasiswa'])
->group(function () {

    Route::resource('rpks', RpkController::class);

    Route::get('/rpks/{rpk}/kegiatans',
    [KegiatanController::class, 'index'])
    ->name('kegiatans.index');

Route::get('/rpks/{rpk}/kegiatans/create',
    [KegiatanController::class, 'create'])
    ->name('kegiatans.create');

Route::post('/rpks/{rpk}/kegiatans',
    [KegiatanController::class, 'store'])
    ->name('kegiatans.store');

});

Route::middleware(['auth', 'role:Dosen'])->group(function () {

    Route::get('/dosen/kegiatan', [DosenKegiatanController::class, 'index'])
        ->name('dosen.kegiatan.index');

    Route::put('/dosen/kegiatan/{kegiatan}/approve',
        [DosenKegiatanController::class, 'approve'])
        ->name('dosen.kegiatan.approve');

    Route::put('/dosen/kegiatan/{kegiatan}/reject',
        [DosenKegiatanController::class, 'reject'])
        ->name('dosen.kegiatan.reject');

});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';