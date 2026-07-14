<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\RpkController;
use App\Http\Controllers\KegiatanController;
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
use App\Http\Controllers\AdminUserApprovalController;

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

    // Rekap 10 Terbaru — query terbatas
    $rekapPrestasi = Spk::with(['user', 'kegiatan', 'prestasi'])
        ->where('status', 'disetujui')
        ->latest()
        ->take(10)
        ->get();

    // Chart 1: Prodi — DB-level groupBy
    $prodiData = Spk::selectRaw('users.prodi, COUNT(*) as total')
        ->join('users', 'spks.user_id', '=', 'users.id')
        ->where('spks.status', 'disetujui')
        ->groupBy('users.prodi')
        ->get();
    $chartLabels = $prodiData->pluck('prodi')->map(fn($v) => $v ?? 'Lainnya')->toArray();
    $chartData = $prodiData->pluck('total')->toArray();

    // Chart 2: Tingkat — DB-level groupBy
    $tingkatData = Spk::selectRaw('COALESCE(tingkat, "Lainnya") as tingkat, COUNT(*) as total')
        ->where('status', 'disetujui')
        ->groupBy('tingkat')
        ->get();
    $tingkatLabels = $tingkatData->pluck('tingkat')->toArray();
    $tingkatData = $tingkatData->pluck('total')->toArray();

    // Chart 3: Jenis Kegiatan — DB-level groupBy via join
    $jenisData = Spk::selectRaw('kegiatans.kegiatan, COUNT(*) as total')
        ->join('kegiatans', 'spks.kegiatan_id', '=', 'kegiatans.id')
        ->where('spks.status', 'disetujui')
        ->groupBy('kegiatans.kegiatan')
        ->get();
    $jenisLabels = $jenisData->pluck('kegiatan')->toArray();
    $jenisData = $jenisData->pluck('total')->toArray();

    // Tren Bulanan — 1 query grouped
    $trenBulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    $tahunSekarang = date('Y');
    $trenBulanData = [];
    for ($i = 1; $i <= 12; $i++) {
        $trenBulanData[] = Spk::where('status', 'disetujui')
            ->whereYear('created_at', $tahunSekarang)
            ->whereMonth('created_at', $i)
            ->count();
    }

    // Top 5 Penyelenggara — DB-level groupBy
    $penyelenggaraData = Spk::selectRaw('penyelenggara, COUNT(*) as total')
        ->where('status', 'disetujui')
        ->whereNotNull('penyelenggara')
        ->groupBy('penyelenggara')
        ->orderByDesc('total')
        ->take(5)
        ->get();
    $penyelenggaraLabels = $penyelenggaraData->pluck('penyelenggara')->toArray();
    $penyelenggaraData = $penyelenggaraData->pluck('total')->toArray();

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
        'jenisData',
        'trenBulanLabels',
        'trenBulanData',
        'penyelenggaraLabels',
        'penyelenggaraData'
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
    Route::put('/users/{user}/approve', [AdminUserApprovalController::class, 'approve'])->name('users.approve');
    Route::delete('/users/{user}/reject', [AdminUserApprovalController::class, 'reject'])->name('users.reject');

    /* Dosen Pembimbing */
    Route::get('/pembimbing', [UserController::class, 'pembimbingIndex'])->name('pembimbing.index');
    Route::post('/pembimbing/set', [UserController::class, 'setPembimbing'])->name('pembimbing.set');

    /* Master Kegiatan */
    Route::resource('kegiatan', MasterKegiatanController::class)->except(['show']);

    /* Master Prestasi (Dibersihkan dari duplikasi) */
    Route::resource('master-prestasi', MasterPrestasiController::class)->except(['create', 'edit']);

    /* Program Studi */
    Route::resource('prodi', ProgramStudiController::class)->except(['create', 'edit'])->parameters(['prodi' => 'prodi']);
    Route::patch('prodi/{prodi}/toggle-status', [ProgramStudiController::class, 'toggleStatus'])->name('prodi.toggle-status');

    /* Laporan */
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');

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

        // Approve & Reject
        Route::post('/{spk}/approve', [AdminSpkController::class, 'approve'])->name('approve');
        Route::post('/{spk}/reject', [AdminSpkController::class, 'reject'])->name('reject');

        // Delete
        Route::delete('/{spk}', [AdminSpkController::class, 'destroy'])->name('destroy');

        // ⚡ POIN
        Route::post('/{spk}/tambah-poin', [AdminSpkController::class, 'tambahPoin'])->name('tambah-poin');
        Route::post('/{spk}/edit-poin', [AdminSpkController::class, 'editPoin'])->name('edit-poin'); // ⚡ TAMBAH
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
    Route::get('/laporan/export-excel', [LaporanDosenController::class, 'exportExcel'])->name('laporan.export-excel');
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
Route::get('/users-data', [UserController::class, 'getUsersData'])->middleware('auth');

require __DIR__ . '/auth.php';
