<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\KkmRuleController;
use App\Http\Controllers\Admin\ProgramStudiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\RpkController as AdminRpkController;
use App\Http\Controllers\Admin\SpkController as AdminSpkController;
use App\Http\Controllers\Admin\CompetencyFieldController;
use App\Http\Controllers\Admin\ActivityTypeController;
use App\Http\Controllers\Admin\ActivityScopeController;
use App\Http\Controllers\Admin\ActivityRoleController;
use App\Http\Controllers\Admin\AchievementTypeController;
use App\Http\Controllers\Admin\PointRuleController;
use App\Http\Controllers\Admin\Api\RuleOptionsController;
use App\Http\Controllers\Dosen\RpkController as DosenRpkController;
use App\Http\Controllers\Dosen\SpkController as DosenSpkController;
use App\Http\Controllers\Dosen\MahasiswaController;
use App\Http\Controllers\Dosen\LaporanController as DosenLaporanController;
use App\Http\Controllers\Mahasiswa\RpkController;
use App\Http\Controllers\Mahasiswa\KegiatanController;
use App\Http\Controllers\Mahasiswa\SpkController;
use App\Models\User;
use App\Models\Spk;

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
    $rekapPrestasi = Spk::with(['user', 'kegiatan'])
        ->where('status', 'disetujui')
        ->latest()
        ->take(10)
        ->get();

    return view('welcome', compact(
        'totalMahasiswa',
        'spkDraft',
        'spkDisetujui',
        'mahasiswaBerprestasi',
        'rekapPrestasi'
    ));
});

Route::get('/statistik', function () {
    $totalMahasiswa = User::role('Mahasiswa')->count();
    $spkDraft = Spk::where('status', 'draft')->count();
    $spkDisetujui = Spk::where('status', 'disetujui')->count();

    $rekapPrestasi = Spk::with(['user', 'kegiatan'])
        ->where('status', 'disetujui')->latest()->take(10)->get();

    $prodiData = Spk::selectRaw('users.prodi, COUNT(*) as total')
        ->join('users', 'spks.user_id', '=', 'users.id')
        ->where('spks.status', 'disetujui')->groupBy('users.prodi')->get();
    $chartLabels = $prodiData->pluck('prodi')->map(fn($v) => $v ?? 'Lainnya')->toArray();
    $chartData = $prodiData->pluck('total')->toArray();

    $tingkatData = Spk::join('kegiatans', 'spks.kegiatan_id', '=', 'kegiatans.id')
        ->join('point_rules', 'kegiatans.point_rule_id', '=', 'point_rules.id')
        ->join('activity_scopes', 'point_rules.scope_id', '=', 'activity_scopes.id')
        ->selectRaw('COALESCE(activity_scopes.name, "Lainnya") as ruang_lingkup, COUNT(*) as total')
        ->where('spks.status', 'disetujui')
        ->groupBy('activity_scopes.name')
        ->get();
    $tingkatLabels = $tingkatData->pluck('ruang_lingkup')->toArray();
    $tingkatData = $tingkatData->pluck('total')->toArray();

    $jenisData = Spk::selectRaw('kegiatans.kegiatan, COUNT(*) as total')
        ->join('kegiatans', 'spks.kegiatan_id', '=', 'kegiatans.id')
        ->where('spks.status', 'disetujui')->groupBy('kegiatans.kegiatan')->get();
    $jenisLabels = $jenisData->pluck('kegiatan')->toArray();
    $jenisData = $jenisData->pluck('total')->toArray();

    $trenBulanLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    $trenBulanData = [];
    for ($i = 1; $i <= 12; $i++) {
        $trenBulanData[] = Spk::where('status', 'disetujui')
            ->whereYear('created_at', date('Y'))->whereMonth('created_at', $i)->count();
    }

    $penyelenggaraData = Spk::selectRaw('penyelenggara, COUNT(*) as total')
        ->where('status', 'disetujui')->whereNotNull('penyelenggara')
        ->groupBy('penyelenggara')->orderByDesc('total')->take(5)->get();
    $penyelenggaraLabels = $penyelenggaraData->pluck('penyelenggara')->toArray();
    $penyelenggaraData = $penyelenggaraData->pluck('total')->toArray();

    return view('statistik', compact(
        'totalMahasiswa', 'spkDraft', 'spkDisetujui',
        'rekapPrestasi', 'chartLabels', 'chartData',
        'tingkatLabels', 'tingkatData', 'jenisLabels', 'jenisData',
        'trenBulanLabels', 'trenBulanData', 'penyelenggaraLabels', 'penyelenggaraData'
    ));
});

// Halaman Kontak
Route::get('/kontak', function () {
    return view('kontak');
})->name('kontak');

/*
|--------------------------------------------------------------------------
| AUTH & PROFILE ROUTES (SEMUA USER LOGIN)
|--------------------------------------------------------------------------
*/
// ⚡ Dashboard dikunci dengan verified
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/realtime', [DashboardController::class, 'realtime'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard.realtime');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    /* KKM Rules Cascade API */
    Route::get('/kkm-rules/options', [KkmRuleController::class, 'options'])->name('kkm-rules.options');

    /* Rules Options API (for cascade dropdowns) */
    Route::get('/api/admin/competency-fields', [RuleOptionsController::class, 'competencyFields']);
    Route::get('/api/admin/activity-types', [RuleOptionsController::class, 'activityTypes']);
    Route::get('/api/admin/activity-scopes', [RuleOptionsController::class, 'activityScopes']);
    Route::get('/api/admin/activity-roles', [RuleOptionsController::class, 'activityRoles']);
    Route::get('/api/admin/point-rules/preview', [RuleOptionsController::class, 'preview']);
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
    Route::resource('users', UserController::class)->except(['create', 'edit']);
    Route::post('/users/{user}/role', [UserRoleController::class, 'update'])->name('users.role.update');

    /* ⚡ Plotting Dosen Pembimbing per RPK */
    Route::post('/rpk/{rpk}/set-pembimbing', [AdminRpkController::class, 'setPembimbing'])->name('rpk.set-pembimbing');
    Route::get('/dosen-list', [AdminRpkController::class, 'dosenList'])->name('dosen-list');

    /* Rules Kredit Keaktifan - Master Tables */
    Route::resource('competency-fields', CompetencyFieldController::class)->except(['create', 'edit', 'show']);
    Route::resource('activity-types', ActivityTypeController::class)->except(['create', 'edit', 'show']);
    Route::resource('activity-scopes', ActivityScopeController::class)->except(['create', 'edit', 'show']);
    Route::resource('activity-roles', ActivityRoleController::class)->except(['create', 'edit', 'show']);
    Route::resource('achievement-types', AchievementTypeController::class)->except(['create', 'edit', 'show']);
    Route::resource('point-rules', PointRuleController::class)->except(['create', 'edit', 'show']);

    /* Backward compatibility - old kkm-rules route */
    Route::resource('kkm-rules', KkmRuleController::class)->except(['create', 'edit', 'show']);

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
        // Detail SPK
        Route::get('/{spk}', [AdminSpkController::class, 'show'])->name('show');

        // Approve & Reject
        Route::post('/{spk}/approve', [AdminSpkController::class, 'approve'])->name('approve');
        Route::post('/{spk}/reject', [AdminSpkController::class, 'reject'])->name('reject');

        // Delete
        Route::delete('/{spk}', [AdminSpkController::class, 'destroy'])->name('destroy');
    });

    /* Log & Aktivitas */
    Route::get('/logs', [\App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('logs.index');
    Route::delete('/logs/{activity}', [\App\Http\Controllers\Admin\ActivityLogController::class, 'destroy'])->name('logs.destroy');
});
Route::middleware(['auth', 'role:Dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/rpk', [DosenRpkController::class, 'index'])->name('rpk.index');
    Route::get('/rpk/{rpk}', [DosenRpkController::class, 'show'])->name('rpk.show');
    Route::put('/rpk/{rpk}/approve', [DosenRpkController::class, 'approve'])->name('rpk.approve');
    Route::put('/rpk/{rpk}/reject', [DosenRpkController::class, 'reject'])->name('rpk.reject');

    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');

    Route::get('/spk', [DosenSpkController::class, 'index'])->name('spk.index');
    Route::get('/spk/{spk}', [DosenSpkController::class, 'show'])->name('spk.show');
    Route::put('/spk/{spk}/approve', [DosenSpkController::class, 'approve'])->name('spk.approve');
    Route::put('/spk/{spk}/reject', [DosenSpkController::class, 'reject'])->name('spk.reject');

    Route::get('/laporan', [DosenLaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export', [DosenLaporanController::class, 'export'])->name('laporan.export');
    Route::get('/laporan/export-excel', [DosenLaporanController::class, 'exportExcel'])->name('laporan.export-excel');
    Route::get('/laporan/export-pdf', [DosenLaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
});

/*
|--------------------------------------------------------------------------
| 🔧 ROLE: MAHASISWA (DIKUNCI DENGAN VERIFIED)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'role:Mahasiswa'])->group(function () {
    // Rencana Kegiatan (RPK)
    Route::resource('rpks', RpkController::class)->except(['create']);

    // Item Kegiatan di dalam RPK
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
Route::get('/users-data', [UserController::class, 'getUsersData'])->middleware(['auth', 'role:Admin']);

Route::get('/sitemap.xml', function () {
    $urls = [
        ['loc' => url('/'), 'priority' => '1.0'],
        ['loc' => url('/statistik'), 'priority' => '0.8'],
        ['loc' => url('/login'), 'priority' => '0.5'],
        ['loc' => url('/register'), 'priority' => '0.5'],
    ];

    return response()->view('sitemap', compact('urls'))->header('Content-Type', 'application/xml');
});

require __DIR__ . '/auth.php';
