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

        if ($user->roles->contains('name', 'Admin')) {

            $totalMahasiswa = User::role('Mahasiswa')->count();
            $totalDosen = User::role('Dosen')->count();

            // Total RPK dari model Rpk
            $totalRpk = Rpk::count();
            $totalSpk = Spk::count();

            // Status dari RPK
            $rpkDraft = Rpk::where('status', 'draft')->count();
            $rpkDiajukan = Rpk::where('status', 'diajukan')->count();
            $rpkDisetujui = Rpk::where('status', 'disetujui')->count();
            $rpkDitolak = Rpk::where('status', 'ditolak')->count();

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

            // ⚡ DONUT CHART ADMIN - GANTI jenis KE kategori
            $kategoriGrup = Spk::with('kegiatan')
                ->where('status', 'disetujui')
                ->get()
                ->groupBy(function ($spk) {
                    return $spk->kegiatan->kategori ?? 'Lainnya'; // ⚡ GANTI jenis -> kategori
                });

            $kategoriLabels = $kategoriGrup->keys()->toArray();
            $kategoriData = $kategoriGrup->map->count()->values()->toArray();

            // TOP MAHASISWA
            $topMahasiswa = User::role('Mahasiswa')
                ->get()
                ->map(function ($user) {
                    // Poin dari SPK milik sendiri (sebagai ketua)
                    $poinSendiri = Spk::where('user_id', $user->id)
                        ->where('status', 'disetujui')
                        ->sum('poin');

                    // Poin dari SPK di mana user adalah anggota
                    $poinAnggota = Spk::where('status', 'disetujui')
                        ->whereHas('kegiatan.anggota', function ($q) use ($user) {
                            $q->where('user_id', $user->id);
                        })
                        ->sum('poin');

                    // Total poin
                    $user->total_poin = $poinSendiri + $poinAnggota;

                    return $user;
                })
                ->sortByDesc('total_poin')
                ->take(5);

            // AKTIVITAS MAHASISWA - RPK
            $aktivitasRpkMahasiswa = Rpk::with('user')
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'aktor'      => $item->user->name ?? '-',
                        'role'       => 'Mahasiswa',
                        'kategori'   => 'RPK', // ⚡ GANTI jenis -> kategori
                        'aktivitas'  => 'Membuat RPK',
                        'status'     => $item->status,
                        'created_at' => $item->created_at,
                    ];
                });

            // AKTIVITAS MAHASISWA - SPK
            $aktivitasSpkMahasiswa = Spk::with(['user', 'kegiatan'])
                ->latest()
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'aktor'      => $item->user->name ?? '-',
                        'role'       => 'Mahasiswa',
                        'kategori'   => 'SPK', // ⚡ GANTI jenis -> kategori
                        'aktivitas'  => 'Mengajukan SPK : ' . ($item->kegiatan->kegiatan ?? '-'),
                        'status'     => $item->status,
                        'created_at' => $item->created_at,
                    ];
                });

            // AKTIVITAS DOSEN - RPK
            $aktivitasRpkDosen = Rpk::with(['user.dosenPembimbing'])
                ->whereIn('status', ['disetujui', 'ditolak'])
                ->latest('updated_at')
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'aktor'      => $item->user->dosenPembimbing->name ?? 'Dosen (Tidak Diketahui)',
                        'role'       => 'Dosen',
                        'kategori'   => 'RPK', // ⚡ GANTI jenis -> kategori
                        'aktivitas'  => $item->status == 'disetujui'
                            ? 'Menyetujui RPK milik ' . ($item->user->name ?? '-')
                            : 'Menolak RPK milik ' . ($item->user->name ?? '-'),
                        'status'     => $item->status,
                        'created_at' => $item->updated_at,
                    ];
                });

            // AKTIVITAS DOSEN - SPK
            $aktivitasSpkDosen = Spk::with(['user.dosenPembimbing'])
                ->whereIn('status', ['disetujui', 'ditolak'])
                ->latest('updated_at')
                ->take(10)
                ->get()
                ->map(function ($item) {
                    return [
                        'aktor'      => $item->user->dosenPembimbing->name ?? 'Dosen (Tidak Diketahui)',
                        'role'       => 'Dosen',
                        'kategori'   => 'SPK', // ⚡ GANTI jenis -> kategori
                        'aktivitas'  => $item->status == 'disetujui'
                            ? 'Menyetujui SPK "' . ($item->kegiatan->kegiatan ?? '-') . '" milik ' . ($item->user->name ?? '-')
                            : 'Menolak SPK "' . ($item->kegiatan->kegiatan ?? '-') . '" milik ' . ($item->user->name ?? '-'),
                        'status'     => $item->status,
                        'created_at' => $item->updated_at,
                    ];
                });

            // GABUNGKAN SEMUA AKTIVITAS
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
                'rpkDiajukan',
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
                'kategoriLabels',   // ⚡ GANTI jenisLabels -> kategoriLabels
                'kategoriData',     // ⚡ GANTI jenisData -> kategoriData
                'topMahasiswa'
            ));
        }

        /*
|--------------------------------------------------------------------------
| Dashboard Dosen
|--------------------------------------------------------------------------
*/

        if ($user->roles->contains('name', 'Dosen')) {

            // Ambil ID mahasiswa bimbingan
            $mahasiswaBimbinganIds = User::where('dosen_pembimbing_id', $user->id)->pluck('id');

            $totalMahasiswa = $mahasiswaBimbinganIds->count();

            // ⚡ RPK - filter per status
            $rpkDraft = Rpk::whereIn('user_id', $mahasiswaBimbinganIds)
                ->where('status', 'draft')
                ->count();

            $rpkDisetujui = Rpk::whereIn('user_id', $mahasiswaBimbinganIds)
                ->where('status', 'disetujui')
                ->count();

            $rpkDitolak = Rpk::whereIn('user_id', $mahasiswaBimbinganIds)
                ->where('status', 'ditolak')
                ->count();

            // ⚡ SPK - filter per status
            $spkDraft = Spk::whereIn('user_id', $mahasiswaBimbinganIds)
                ->where('status', 'draft')
                ->count();

            $spkDisetujui = Spk::whereIn('user_id', $mahasiswaBimbinganIds)
                ->where('status', 'disetujui')
                ->count();

            $spkDitolak = Spk::whereIn('user_id', $mahasiswaBimbinganIds)
                ->where('status', 'ditolak')
                ->count();

            // ⚡ DEBUG: Cek nilai di log
            \Log::info('Dashboard Dosen Debug', [
                'user_id' => $user->id,
                'mahasiswa_ids' => $mahasiswaBimbinganIds->toArray(),
                'rpkDraft' => $rpkDraft,
                'rpkDisetujui' => $rpkDisetujui,
                'spkDraft' => $spkDraft,
                'spkDisetujui' => $spkDisetujui,
            ]);

            return view('dashboard.dosen', compact(
                'totalMahasiswa',
                'rpkDraft',
                'rpkDisetujui',
                'rpkDitolak',
                'spkDraft',
                'spkDisetujui',
                'spkDitolak'
            ));
        }

        /*
        |--------------------------------------------------------------------------
        | Dashboard Mahasiswa (SEMUA SAMA - TERMASUK ANGGOTA)
        |--------------------------------------------------------------------------
        */

        // Dosen Pembimbing
        $dosenPembimbing = $user->dosenPembimbing;

        // RPK di mana user jadi anggota (tambahan info)
        $rpkAnggota = Rpk::whereHas('kegiatans.anggota', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('user_id', '!=', $user->id)->latest()->get();

        // CARD STATISTIK (dari RPK & SPK milik sendiri)
        $rpkDraft = Rpk::where('user_id', $user->id)->where('status', 'draft')->count();
        $rpkDisetujui = Rpk::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $rpkDitolak = Rpk::where('user_id', $user->id)->where('status', 'ditolak')->count();

        $spkDraft = Spk::where('user_id', $user->id)->where('status', 'draft')->count();
        $spkDisetujui = Spk::where('user_id', $user->id)->where('status', 'disetujui')->count();
        $spkDitolak = Spk::where('user_id', $user->id)->where('status', 'ditolak')->count();

        // Total Poin = Poin dari SPK sendiri + Poin dari SPK sebagai anggota
        $poinSendiri = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->sum('poin');

        $poinAnggota = Spk::where('status', 'disetujui')
            ->whereHas('kegiatan.anggota', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->where('user_id', '!=', $user->id)
            ->sum('poin');

        $totalPoin = $poinSendiri + $poinAnggota;

        // Total Kegiatan = RPK Disetujui + SPK Disetujui
        $totalKegiatan = $rpkDisetujui + $spkDisetujui;

        // Jumlah Ditolak
        $jumlahDitolak = $rpkDitolak + $spkDitolak;

        // Persentase Disetujui
        $totalSemua = $totalKegiatan + $jumlahDitolak;
        $persentase = $totalSemua > 0
            ? round(($totalKegiatan / $totalSemua) * 100)
            : 0;

        // PIE CHART: Status KESELURUHAN (RPK + SPK)
        $draft = $rpkDraft + $spkDraft;
        $disetujui = $rpkDisetujui + $spkDisetujui;
        $ditolak = $rpkDitolak + $spkDitolak;

        // BAR CHART - Tingkat dari SPK (kolom tingkat)
        $universitas = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->where('tingkat', 'Universitas')
            ->count();

        $regional = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->where('tingkat', 'Regional')
            ->count();

        $nasional = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->where('tingkat', 'Nasional')
            ->count();

        $internasional = Spk::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->where('tingkat', 'Internasional')
            ->count();

        // ⚡ DONUT CHART - GANTI jenis KE kategori
        $kegiatanUser = Kegiatan::whereHas('rpk', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });

        $kategori = (clone $kegiatanUser)
            ->selectRaw('kategori, COUNT(*) as total') // ⚡ GANTI jenis -> kategori
            ->groupBy('kategori')                       // ⚡ GANTI jenis -> kategori
            ->get();

        $kategoriLabels = $kategori->pluck('kategori'); // ⚡ GANTI jenis -> kategori
        $kategoriData = $kategori->pluck('total');

        // LINE CHART - Aktivitas Bulanan
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $bulanData = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulanData[] = Kegiatan::whereHas('rpk', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
                ->whereMonth('created_at', $i)
                ->count();
        }

        // AKTIVITAS TERBARU
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
            'kategoriLabels',   // ⚡ GANTI jenisLabels -> kategoriLabels
            'kategoriData',     // ⚡ GANTI jenisData -> kategoriData
            'bulanLabels',
            'bulanData',
            'jumlahDitolak',
            'kegiatanTerbaru',
            'rpkAnggota'
        ));
    }
}
