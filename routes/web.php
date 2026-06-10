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
use App\Http\Controllers\DosenMahasiswaController;
use App\Http\Controllers\MasterKegiatanController;
use App\Http\Controllers\ProgramStudiController;
use App\Models\User;
use App\Models\Spk;
use App\Http\Controllers\LaporanController;

Route::get(
    '/admin/laporan/export-pdf',
    [LaporanController::class, 'exportPdf']
)->name('admin.laporan.export-pdf');



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTE (BERANDA SIPRESMA)
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $totalMahasiswa = User::role('Mahasiswa')->count(); 
    $spkDraft = Spk::where('status', 'draft')->count();
    $spkDisetujui = Spk::where('status', 'disetujui')->count();
    
    $mahasiswaBerprestasi = Spk::where('status', 'disetujui')
                                ->distinct('user_id')
                                ->count('user_id');

    // Mengambil data SPK disetujui beserta relasi user & kegiatan
    $spkDisetujuiData = Spk::with(['user', 'kegiatan'])->where('status', 'disetujui')->get();

    // Data List Rekap 10 Terbaru
    $rekapPrestasi = $spkDisetujuiData->sortByDesc('updated_at')->take(10);

    // Data Chart 1: Prodi
    $prodiGrup = $spkDisetujuiData->groupBy(function($spk) {
        return $spk->user->prodi ?? 'Lainnya';
    });
    $chartLabels = $prodiGrup->keys()->toArray();
    $chartData = $prodiGrup->map->count()->values()->toArray();

    // Data Chart 2: Tingkat Kegiatan
    $tingkatGrup = $spkDisetujuiData->groupBy(function($spk) {
        return $spk->kegiatan->tingkat ?? 'Lainnya';
    });
    $tingkatLabels = $tingkatGrup->keys()->toArray();
    $tingkatData = $tingkatGrup->map->count()->values()->toArray();

    // Data Chart 3: Jenis Kegiatan
    $jenisGrup = $spkDisetujuiData->groupBy(function($spk) {
        return $spk->kegiatan->jenis ?? 'Lainnya';
    });
    $jenisLabels = $jenisGrup->keys()->toArray();
    $jenisData = $jenisGrup->map->count()->values()->toArray();

    return view('welcome', compact(
        'totalMahasiswa',
        'spkDraft',
        'spkDisetujui',
        'mahasiswaBerprestasi',
        'rekapPrestasi',
        'chartLabels',
        'chartData',
        'tingkatLabels',
        'tingkatData',
        'jenisLabels',
        'jenisData'
    ));
});

/*
|--------------------------------------------------------------------------
| AUTH & PROFILE ROUTES (SEMUA USER LOGIN)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ROLE: ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/', function () {
        $users = User::with('roles')->orderBy('id', 'asc')->get();
        return view('admin.dashboard', compact('users'));
    })->name('dashboard');

    // Manajemen Pengguna (Users & Roles)
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'store' => 'users.store',
        'show' => 'users.show',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);
    Route::post('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.role.update');

    // Dosen Pembimbing
    Route::get('/pembimbing', [UserController::class, 'pembimbingIndex'])->name('pembimbing.index');
    Route::post('/pembimbing/set', [UserController::class, 'setPembimbing'])->name('pembimbing.set');

    // Master Kegiatan
    Route::resource('kegiatan', MasterKegiatanController::class)->except(['show']);

    // Master Program Studi
    Route::resource('prodi', ProgramStudiController::class)->except(['create', 'edit', 'show']);
});

Route::middleware(['auth','role:Admin'])->group(function () {

    Route::get('/admin/laporan', [LaporanController::class, 'index'])
        ->name('admin.laporan.index');

});

Route::middleware(['auth','role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/laporan', [LaporanController::class, 'index'])
            ->name('laporan.index');

        Route::get('/laporan/export', [LaporanController::class, 'export'])
            ->name('laporan.export');

    });

    Route::middleware(['auth','role:Admin'])->group(function () {

    Route::get('/admin/laporan', [LaporanController::class, 'index'])
        ->name('admin.laporan.index');

    Route::get('/admin/laporan/export', [LaporanController::class, 'export'])
        ->name('admin.laporan.export');

Route::get(
    '/admin/laporan/export',
    [LaporanController::class, 'export']
)->name('admin.laporan.export');

});


/*
|--------------------------------------------------------------------------
| ROLE: DOSEN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    
    // Mahasiswa Bimbingan
    Route::get('/mahasiswa', [DosenMahasiswaController::class, 'index'])->name('mahasiswa.index');

    // Persetujuan RPK
    Route::get('/kegiatan', [DosenKegiatanController::class, 'index'])->name('kegiatan.index');
    Route::get('/kegiatan/{kegiatan}', [DosenKegiatanController::class, 'show'])->name('kegiatan.show');
    Route::put('/kegiatan/{kegiatan}/approve', [DosenKegiatanController::class, 'approve'])->name('kegiatan.approve');
    Route::put('/kegiatan/{kegiatan}/reject', [DosenKegiatanController::class, 'reject'])->name('kegiatan.reject');

    // Persetujuan SPK
    Route::get('/spk', [DosenSpkController::class, 'index'])->name('spk.index');
    Route::get('/spk/{spk}', [DosenSpkController::class, 'show'])->name('spk.show');
    Route::put('/spk/{spk}/approve', [DosenSpkController::class, 'approve'])->name('spk.approve');
    Route::put('/spk/{spk}/reject', [DosenSpkController::class, 'reject'])->name('spk.reject');
});

/*
|--------------------------------------------------------------------------
| ROLE: MAHASISWA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Mahasiswa'])->group(function () {
    
    // Rencana Kegiatan (RPK)
    Route::resource('rpks', RpkController::class);
    
    // Item Kegiatan di dalam RPK
    Route::get('/rpks/{rpk}/kegiatans', [KegiatanController::class, 'index'])->name('kegiatans.index');
    Route::get('/rpks/{rpk}/kegiatans/create', [KegiatanController::class, 'create'])->name('kegiatans.create');
    Route::post('/rpks/{rpk}/kegiatans', [KegiatanController::class, 'store'])->name('kegiatans.store');
    Route::get('/kegiatan/{kegiatan}/edit', [KegiatanController::class, 'edit'])->name('kegiatans.edit');
    Route::put('/kegiatan/{kegiatan}', [KegiatanController::class, 'update'])->name('kegiatans.update');
    Route::delete('/kegiatans/{kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatans.destroy');

    // Sertifikat Prestasi Kegiatan (SPK)
    Route::resource('spks', SpkController::class);
});

/*
|--------------------------------------------------------------------------
| MISCELLANEOUS / API
|--------------------------------------------------------------------------
*/
Route::get('/users-data', [UserController::class, 'getUsersData']);

require __DIR__.'/auth.php';