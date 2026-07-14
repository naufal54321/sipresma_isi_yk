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
            $tingkat = $this->dashboardService->getAdminTingkatChart();
            $kategori = $this->dashboardService->getAdminKategoriChart();
            $topMahasiswa = $this->dashboardService->getTopMahasiswa();
            $aktivitasTerbaru = $this->dashboardService->getAktivitasTerbaru();

            return view('dashboard.admin', array_merge(
                $stats, $tingkat, $kategori,
                compact('topMahasiswa', 'aktivitasTerbaru')
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

        $dosenPembimbing = $user->dosenPembimbing;

        $rpkAnggota = Rpk::whereHas('kegiatans.anggota', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('user_id', '!=', $user->id)->latest()->get();

        $stats = $this->dashboardService->getMahasiswaStats($user->id);
        $tingkat = $this->dashboardService->getMahasiswaTingkatChart($user->id);
        $kategori = $this->dashboardService->getMahasiswaKategoriChart($user->id);
        $bulanan = $this->dashboardService->getMahasiswaBulananChart($user->id);
        $kegiatanTerbaru = $this->dashboardService->getMahasiswaKegiatanTerbaru($user->id);

        return view('dashboard.mahasiswa', array_merge(
            compact('dosenPembimbing', 'rpkAnggota', 'kegiatanTerbaru'),
            $stats, $tingkat, $kategori, $bulanan
        ));
    }
}
