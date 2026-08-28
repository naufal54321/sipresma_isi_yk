<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Models\User;
use App\Models\Rpk;
use App\Models\Spk;
use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $user = Auth::user();

        if ($user->roles->contains('name', 'Admin')) {
            $stats = $this->dashboardService->getAdminStats();
            $tingkat = $this->dashboardService->getAdminRuangLingkupChart();
            $kategori = $this->dashboardService->getAdminKategoriChart();
            $topMahasiswa = $this->dashboardService->getTopMahasiswa();
            $aktivitasTerbaru = $this->dashboardService->getAktivitasTerbaru();
            $rasio = $this->dashboardService->getAdminRasioBimbingan();

            return view('dashboard.admin', array_merge(
                $stats, $kategori,
                compact('topMahasiswa', 'aktivitasTerbaru', 'rasio', 'tingkat')
            ));
        }

        if ($user->roles->contains('name', 'Dosen')) {
            $stats = $this->dashboardService->getDosenStats($user->id);

            \Log::info('Dashboard Dosen Debug', [
                'user_id' => $user->id,
                'rpkDraft' => $stats['rpkDraft'],
                'rpkDisetujui' => $stats['rpkDisetujui'],
                'spkDraft' => $stats['spkDraft'],
                'spkDisetujui' => $stats['spkDisetujui'],
            ]);

            return view('dashboard.dosen', $stats);
        }

        $dosenPembimbing = $user->rpks()->latest()->first()?->dosenPembimbing;

        $stats = $this->dashboardService->getMahasiswaStats($user->id);
        $tingkat = $this->dashboardService->getMahasiswaRuangLingkupChart($user->id);
        $kategori = $this->dashboardService->getMahasiswaKategoriChart($user->id);
        $bulanan = $this->dashboardService->getMahasiswaBulananChart($user->id);
        $kegiatanTerbaru = $this->dashboardService->getMahasiswaKegiatanTerbaru($user->id);

        return view('dashboard.mahasiswa', array_merge(
            $stats, $kategori, $bulanan,
            compact('dosenPembimbing', 'kegiatanTerbaru', 'tingkat')
        ));
    }

    public function realtime()
    {
        $user = Auth::user();

        if ($user->roles->contains('name', 'Admin')) {
            $stats = $this->dashboardService->getAdminStats();
            $tingkat = $this->dashboardService->getAdminRuangLingkupChart();
            $kategori = $this->dashboardService->getAdminKategoriChart();

            $aktivitasTerbaru = $this->dashboardService->getAktivitasTerbaru()
                ->map(function ($item) {
                    $item['waktu'] = \Carbon\Carbon::parse($item['created_at'])->locale('id')->isoFormat('DD MMMM YYYY');
                    $item['jam'] = \Carbon\Carbon::parse($item['created_at'])->format('H:i');
                    return $item;
                });

            return response()->json([
                'role' => 'Admin',
                'stats' => $stats,
                'tingkat' => $tingkat->toArray(),
                'kategori' => $kategori,
                'aktivitasTerbaru' => $aktivitasTerbaru,
            ]);
        }

        if ($user->roles->contains('name', 'Dosen')) {
            return response()->json([
                'role' => 'Dosen',
                'stats' => $this->dashboardService->getDosenStats($user->id),
            ]);
        }

        $stats = $this->dashboardService->getMahasiswaStats($user->id);
        $tingkat = $this->dashboardService->getMahasiswaRuangLingkupChart($user->id);
        $kategori = $this->dashboardService->getMahasiswaKategoriChart($user->id);
        $bulanan = $this->dashboardService->getMahasiswaBulananChart($user->id);

        return response()->json([
            'role' => 'Mahasiswa',
            'stats' => $stats,
            'tingkat' => $tingkat->toArray(),
            'kategori' => $kategori,
            'bulanan' => $bulanan,
        ]);
    }
}
