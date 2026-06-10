<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Rpk;
use App\Models\Spk;
use App\Models\Kegiatan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Dashboard Admin
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Admin')) {

            $totalMahasiswa = User::role('Mahasiswa')->count();
            $totalDosen = User::role('Dosen')->count();

            $totalRpk = Kegiatan::count();
            $totalSpk = Spk::count();

            // STATUS RPK
            $rpkDraft = Kegiatan::where('status', 'draft')->count();
            $rpkDisetujui = Kegiatan::where('status', 'disetujui')->count();
            $rpkDitolak = Kegiatan::where('status', 'ditolak')->count();

            // STATUS SPK
            $spkDraft = Spk::where('status', 'draft')->count();
            $spkDisetujui = Spk::where('status', 'disetujui')->count();
            $spkDitolak = Spk::where('status', 'ditolak')->count();

            // BAR CHART ADMIN (Berdasarkan SPK disetujui)
            $universitas = Spk::where('status', 'disetujui')
                ->whereHas('kegiatan', function ($q) {
                    $q->where('tingkat', 'Universitas');
                })->count();

            $regional = Spk::where('status', 'disetujui')
                ->whereHas('kegiatan', function ($q) {
                    $q->where('tingkat', 'Regional');
                })->count();

            $nasional = Spk::where('status', 'disetujui')
                ->whereHas('kegiatan', function ($q) {
                    $q->where('tingkat', 'Nasional');
                })->count();

            $internasional = Spk::where('status', 'disetujui')
                ->whereHas('kegiatan', function ($q) {
                    $q->where('tingkat', 'Internasional');
                })->count();

            // DONUT CHART ADMIN (Menambahkan variabel yang sebelumnya hilang)
            // ==================================================================
            // UBAH BAGIAN INI AGAR MENGAMBIL DATA SPK YANG DISETUJUI (SEPERTI BERANDA)
            // ==================================================================
            $jenisGrup = Spk::with('kegiatan')
                ->where('status', 'disetujui')
                ->get()
                ->groupBy(function($spk) {
                    return $spk->kegiatan->jenis ?? 'Lainnya';
                });

            $jenisLabels = $jenisGrup->keys()->toArray();
            $jenisData = $jenisGrup->map->count()->values()->toArray();
            // ==================================================================

            // TOP MAHASISWA
            $topMahasiswa = User::role('Mahasiswa')
                ->with(['spks.kegiatan.masterKegiatan'])
                ->get()
                ->map(function ($user) {
                    $user->total_poin = $user->spks
                        ->where('status', 'disetujui')
                        ->sum(function ($spk) {
                            return $spk->kegiatan->masterKegiatan->poin ?? 0;
                        });
                    return $user;
                })
                ->sortByDesc('total_poin')
                ->take(5);

            // ==========================
            // AKTIVITAS MAHASISWA - RPK
            // ==========================
            $aktivitasRpkMahasiswa = Kegiatan::with('rpk.user')
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'aktor'      => $item->rpk->user->name ?? '-',
                        'role'       => 'Mahasiswa',
                        'jenis'      => 'RPK',
                        'aktivitas'  => 'Mengajukan RPK : '.$item->kegiatan,
                        'status'     => $item->status,
                        'created_at' => $item->created_at,
                    ];
                });

            // ==========================
            // AKTIVITAS MAHASISWA - SPK
            // ==========================
            $aktivitasSpkMahasiswa = Spk::with(['user','kegiatan'])
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'aktor'      => $item->user->name ?? '-',
                        'role'       => 'Mahasiswa',
                        'jenis'      => 'SPK',
                        'aktivitas'  => 'Mengajukan SPK : '.($item->kegiatan->kegiatan ?? '-'),
                        'status'     => $item->status,
                        'created_at' => $item->created_at,
                    ];
                });

            // ==========================
            // AKTIVITAS DOSEN - RPK
            // ==========================
            $aktivitasRpkDosen = Kegiatan::with('rpk.user')
                ->whereIn('status', ['disetujui','ditolak'])
                ->latest('updated_at')
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'aktor' => 'Dosen',
                        'role' => 'Dosen',
                        'jenis' => 'RPK',
                        'aktivitas' => $item->status == 'disetujui'
                            ? 'Menyetujui RPK "' . $item->kegiatan . '" milik ' . ($item->rpk->user->name ?? '-')
                            : 'Menolak RPK "' . $item->kegiatan . '" milik ' . ($item->rpk->user->name ?? '-'),
                        'status' => $item->status,
                        'created_at' => $item->updated_at,
                    ];
                });

            // ==========================
            // AKTIVITAS DOSEN - SPK
            // ==========================
            $aktivitasSpkDosen = Spk::with('user')
                ->whereIn('status', ['disetujui','ditolak'])
                ->latest('updated_at')
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'aktor' => 'Dosen',
                        'role' => 'Dosen',
                        'jenis' => 'SPK',
                        'aktivitas' => $item->status == 'disetujui'
                            ? 'Menyetujui SPK "' . ($item->kegiatan->kegiatan ?? '-') . '" milik ' . ($item->user->name ?? '-')
                            : 'Menolak SPK "' . ($item->kegiatan->kegiatan ?? '-') . '" milik ' . ($item->user->name ?? '-'),
                        'status' => $item->status,
                        'created_at' => $item->updated_at,
                    ];
                });

            // ==========================
            // GABUNGKAN SEMUA AKTIVITAS
            // ==========================
            $aktivitasTerbaru = collect()
                ->concat($aktivitasRpkMahasiswa)
                ->concat($aktivitasSpkMahasiswa)
                ->concat($aktivitasRpkDosen)
                ->concat($aktivitasSpkDosen)
                ->sortByDesc('created_at')
                ->take(10);

            return view('dashboard.admin', compact(
                'totalMahasiswa',
                'totalDosen',
                'totalRpk',
                'totalSpk',
                'rpkDraft',
                'rpkDisetujui',
                'rpkDitolak',
                'spkDraft',
                'spkDisetujui',
                'spkDitolak',
                'aktivitasTerbaru',
                'universitas',
                'regional',
                'nasional',
                'internasional',
                'jenisLabels',
                'jenisData',
                'topMahasiswa'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Dosen
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Dosen')) {

            $totalMahasiswa = User::where(
                'dosen_pembimbing_id',
                $user->id
            )->count();

            $rpkMenunggu = Kegiatan::where('status', 'draft')->count();

            $spkMenunggu = Spk::where('status', 'draft')->count();

            return view('dashboard.dosen', compact(
                'totalMahasiswa',
                'rpkMenunggu',
                'spkMenunggu'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Mahasiswa
        |--------------------------------------------------------------------------
        */

        $kegiatanUser = Kegiatan::whereHas('rpk', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });

        // Dosen Pembimbing
        $dosenPembimbing = $user->dosenPembimbing;

        // CARD STATISTIK
        $rpkDraft = (clone $kegiatanUser)->where('status', 'draft')->count();
        $rpkDisetujui = (clone $kegiatanUser)->where('status', 'disetujui')->count();

        $spkDraft = Spk::where('user_id', $user->id)->where('status', 'draft')->count();
        $spkDisetujui = Spk::where('user_id', $user->id)->where('status', 'disetujui')->count();

        $totalPoin = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->with('kegiatan.masterKegiatan')
            ->get()
            ->sum(function ($spk) {
                return $spk->kegiatan?->masterKegiatan?->poin ?? 0;
            });

        $totalKegiatan = (clone $kegiatanUser)->count();
        $jumlahDitolak = (clone $kegiatanUser)->where('status', 'ditolak')->count();

        $persentase = $totalKegiatan > 0
            ? round(($rpkDisetujui / $totalKegiatan) * 100)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | PIE CHART
        |--------------------------------------------------------------------------
        */

        $draft = (clone $kegiatanUser)->where('status', 'draft')->count();
        $disetujui = (clone $kegiatanUser)->where('status', 'disetujui')->count();
        $ditolak = (clone $kegiatanUser)->where('status', 'ditolak')->count();

        /*
        |--------------------------------------------------------------------------
        | BAR CHART
        |--------------------------------------------------------------------------
        */
        // BAR CHART (berdasarkan SPK yang sudah disetujui)

        $universitas = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->whereHas('kegiatan', function ($q) {
                $q->where('tingkat', 'Universitas');
            })->count();

        $regional = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->whereHas('kegiatan', function ($q) {
                $q->where('tingkat', 'Regional');
            })->count();

        $nasional = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->whereHas('kegiatan', function ($q) {
                $q->where('tingkat', 'Nasional');
            })->count();

        $internasional = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->whereHas('kegiatan', function ($q) {
                $q->where('tingkat', 'Internasional');
            })->count();

        /*
        |--------------------------------------------------------------------------
        | DONUT CHART
        |--------------------------------------------------------------------------
        */

        $jenis = (clone $kegiatanUser)
            ->selectRaw('jenis, COUNT(*) as total')
            ->groupBy('jenis')
            ->get();

        $jenisLabels = $jenis->pluck('jenis');
        $jenisData = $jenis->pluck('total');

        /*
        |--------------------------------------------------------------------------
        | LINE CHART AKTIVITAS BULANAN
        |--------------------------------------------------------------------------
        */

        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $bulanData = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulanData[] = Kegiatan::whereHas('rpk', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereMonth('created_at', $i)
            ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */

        $kegiatanTerbaru = (clone $kegiatanUser)->latest()->take(5)->get();

        return view('dashboard.mahasiswa', compact(
            'dosenPembimbing',
            'rpkDraft',
            'rpkDisetujui',
            'spkDraft',
            'spkDisetujui',
            'totalPoin',
            'totalKegiatan',
            'persentase',
            'draft',
            'disetujui',
            'ditolak',
            'universitas',
            'regional',
            'nasional',
            'internasional',
            'jenisLabels',
            'jenisData',
            'bulanLabels',
            'bulanData'
        ));
    }
}