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
use App\Http\Controllers\DosenRpkController;
use App\Http\Controllers\DosenSpkController;
use App\Http\Controllers\SpkController;
use App\Http\Controllers\DosenMahasiswaController;
use App\Http\Controllers\MasterKegiatanController;
use App\Http\Controllers\MasterPrestasiController;
use App\Http\Controllers\ProgramStudiController;
use App\Models\User;
use App\Models\Spk;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanDosenController;
use App\Http\Controllers\AdminRpkController;
use App\Http\Controllers\AdminSpkController;

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

    // ⚡ Load dengan relasi prestasi
    $spkDisetujuiData = Spk::with(['user', 'kegiatan', 'prestasi'])
        ->where('status', 'disetujui')
        ->get();

    // Data List Rekap 10 Terbaru
    $rekapPrestasi = $spkDisetujuiData->sortByDesc('updated_at')->take(10);

    // Data Chart 1: Prodi
    $prodiGrup = $spkDisetujuiData->groupBy(function ($spk) {
        return $spk->user->prodi ?? 'Lainnya';
    });
    $chartLabels = $prodiGrup->keys()->toArray();
    $chartData = $prodiGrup->map->count()->values()->toArray();

    // ⚡ Data Chart 2: Tingkat dari master_prestasis
    $tingkatGrup = $spkDisetujuiData->groupBy(function ($spk) {
        return $spk->prestasi->tingkat ?? $spk->tingkat ?? 'Lainnya';
    });
    $tingkatLabels = $tingkatGrup->keys()->toArray();
    $tingkatData = $tingkatGrup->map->count()->values()->toArray();

    // Data Chart 3: Jenis Kegiatan
    $jenisGrup = $spkDisetujuiData->groupBy(function ($spk) {
        return $spk->kegiatan->kegiatan
            ?? $spk->kegiatan->nama_kegiatan
            ?? 'Lainnya';
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
// ⚡ Dashboard dikunci dengan verified
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

    Route::get('/', function () {
        return redirect()->route('admin.users.index');
    })->name('dashboard');

    /* Manajemen User */
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.role.update');

    /* Dosen Pembimbing */
    Route::get('/pembimbing', [UserController::class, 'pembimbingIndex'])->name('pembimbing.index');
    Route::post('/pembimbing/set', [UserController::class, 'setPembimbing'])->name('pembimbing.set');

    /* Master Kegiatan */
    Route::resource('kegiatan', MasterKegiatanController::class)->except(['show']);

    /* Master Prestasi (Dibersihkan dari duplikasi) */
    Route::resource('master-prestasi', MasterPrestasiController::class)->except(['create', 'edit']);

    /* Program Studi */
    Route::resource('prodi', ProgramStudiController::class)->except(['create', 'edit'])->parameters(['prodi' => 'prodi']);
    Route::get('prodi/check-name', [ProgramStudiController::class, 'checkName'])->name('prodi.check-name');
    Route::patch('prodi/{prodi}/toggle-status', [ProgramStudiController::class, 'toggleStatus'])->name('prodi.toggle-status');
    Route::post('prodi/bulk-delete', [ProgramStudiController::class, 'bulkDelete'])->name('prodi.bulk-delete');
    Route::get('prodi/export', [ProgramStudiController::class, 'export'])->name('prodi.export');

    /* Laporan */
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');

    /* RPK Mahasiswa (VIEW OLEH ADMIN) */
    Route::get('/rpk', [AdminRpkController::class, 'index'])->name('rpk.index');
    Route::get('/rpk/{rpk}', [AdminRpkController::class, 'show'])->name('rpk.show');
    Route::patch('/rpk/{rpk}/status', [AdminRpkController::class, 'updateStatus'])->name('rpk.update-status');

    /* ⚡ SPK Management (Admin) - SEMUA METHOD DI AdminSpkController */
    Route::prefix('spk')->name('spk.')->group(function () {
        // List & Kelola Poin
        Route::get('/', [AdminSpkController::class, 'index'])->name('index');
        Route::get('/kelola-poin', [AdminSpkController::class, 'kelolaPoin'])->name('kelola-poin');

        // Detail SPK
        Route::get('/{spk}', [AdminSpkController::class, 'show'])->name('show');

        // ⚡ UBAH: Approve & Reject pakai POST (bukan PATCH) untuk kompatibel AJAX
        Route::post('/{spk}/approve', [AdminSpkController::class, 'approve'])->name('approve');
        Route::post('/{spk}/reject', [AdminSpkController::class, 'reject'])->name('reject');

        // Delete
        Route::delete('/{spk}', [AdminSpkController::class, 'destroy'])->name('destroy');

        // ⚡ TAMBAH POIN: Sekarang di AdminSpkController
        Route::post('/{spk}/tambah-poin', [AdminSpkController::class, 'tambahPoin'])->name('tambah-poin');
    });
});

/*
|--------------------------------------------------------------------------
| ROLE: DOSEN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/rpk', [DosenRpkController::class, 'index'])->name('rpk.index');
    Route::get('/rpk/{rpk}', [DosenRpkController::class, 'show'])->name('rpk.show');
    Route::put('/rpk/{rpk}/approve', [DosenRpkController::class, 'approve'])->name('rpk.approve');
    Route::put('/rpk/{rpk}/reject', [DosenRpkController::class, 'reject'])->name('rpk.reject');

    Route::get('/mahasiswa', [DosenMahasiswaController::class, 'index'])->name('mahasiswa.index');

    Route::get('/spk', [DosenSpkController::class, 'index'])->name('spk.index');
    Route::get('/spk/{spk}', [DosenSpkController::class, 'show'])->name('spk.show');
    Route::put('/spk/{spk}/approve', [DosenSpkController::class, 'approve'])->name('spk.approve');
    Route::put('/spk/{spk}/reject', [DosenSpkController::class, 'reject'])->name('spk.reject');

    Route::get('/laporan', [LaporanDosenController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanDosenController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/export-pdf', [LaporanDosenController::class, 'exportPdf'])->name('laporan.export-pdf');
});

/*
|--------------------------------------------------------------------------
| 🔧 ROLE: MAHASISWA (DIKUNCI DENGAN VERIFIED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:Mahasiswa'])->group(function () {
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

require __DIR__ . '/auth.php';
