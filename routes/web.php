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
use App\Http\Controllers\DosenSpkController;
use App\Http\Controllers\SpkController;
use App\Models\User;
use App\Http\Controllers\DosenMahasiswaController;
use App\Http\Controllers\MasterKegiatanController;

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/kegiatan', [MasterKegiatanController::class, 'index'])
            ->name('kegiatan.index');

        Route::get('/kegiatan/create', [MasterKegiatanController::class, 'create'])
            ->name('kegiatan.create');

        Route::post('/kegiatan', [MasterKegiatanController::class, 'store'])
            ->name('kegiatan.store');
    });


Route::middleware(['auth', 'role:Dosen'])->group(function () {

    Route::get('/dosen/mahasiswa', [DosenMahasiswaController::class, 'index'])
        ->name('dosen.mahasiswa.index');

});


Route::get('/users-data', [UserController::class, 'getUsersData']);

Route::get(
    '/dosen/kegiatan/{kegiatan}',
    [DosenKegiatanController::class, 'show']
)->name('dosen.kegiatan.show');

Route::delete(
    '/kegiatans/{kegiatan}',
    [KegiatanController::class, 'destroy']
)->name('kegiatans.destroy');


Route::resource('spks', SpkController::class);


Route::get('/kegiatan/{kegiatan}/edit',
    [KegiatanController::class, 'edit'])
    ->name('kegiatans.edit');

Route::put('/kegiatan/{kegiatan}',
    [KegiatanController::class, 'update'])
    ->name('kegiatans.update');


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
    $users = User::with('roles')->orderBy('id', 'asc')->get(); // coba ASC dulu
    return view('admin.dashboard', compact('users'));
})->name('admin.dashboard');


     Route::get('/admin/pembimbing', [UserController::class, 'pembimbingIndex'])
        ->name('admin.pembimbing.index');

    Route::post('/admin/pembimbing/set', [UserController::class, 'setPembimbing'])
        ->name('admin.pembimbing.set');

Route::get('/admin/kegiatan/{kegiatan}/edit',
    [MasterKegiatanController::class, 'edit'])
    ->name('admin.kegiatan.edit');

Route::put('/admin/kegiatan/{kegiatan}',
    [MasterKegiatanController::class, 'update'])
    ->name('admin.kegiatan.update');


    Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/kegiatan', [MasterKegiatanController::class, 'index'])
            ->name('kegiatan.index');

        Route::get('/kegiatan/create', [MasterKegiatanController::class, 'create'])
            ->name('kegiatan.create');

        Route::post('/kegiatan', [MasterKegiatanController::class, 'store'])
            ->name('kegiatan.store');

        Route::get('/kegiatan/{kegiatan}/edit', [MasterKegiatanController::class, 'edit'])
            ->name('kegiatan.edit');

        Route::put('/kegiatan/{kegiatan}', [MasterKegiatanController::class, 'update'])
            ->name('kegiatan.update');

        Route::delete('/kegiatan/{kegiatan}', [MasterKegiatanController::class, 'destroy'])
            ->name('kegiatan.destroy');
    });


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

Route::middleware(['auth', 'role:Mahasiswa'])->group(function () {
    Route::resource('spks', SpkController::class);
});

Route::middleware(['auth','role:Dosen'])
    ->prefix('dosen')
    ->name('dosen.')
    ->group(function () {

        Route::get('/spk', [DosenSpkController::class, 'index'])
            ->name('spk.index');

        Route::put('/spk/{spk}/approve', [DosenSpkController::class, 'approve'])
            ->name('spk.approve');

        Route::put('/spk/{spk}/reject', [DosenSpkController::class, 'reject'])
            ->name('spk.reject');
    });

    Route::get('/spk/{spk}', [DosenSpkController::class, 'show'])
    ->name('dosen.spk.show');


    

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';