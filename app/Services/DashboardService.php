<?php

namespace App\Services;

use App\Models\User;
use App\Models\Rpk;
use App\Models\Spk;
use App\Models\Kegiatan;

class DashboardService
{
    public function getAdminStats()
    {
        return [
            'totalMahasiswa' => User::role('Mahasiswa')->count(),
            'totalDosen' => User::role('Dosen')->count(),
            'totalRpk' => Rpk::count(),
            'totalSpk' => Spk::count(),
            'rpkDraft' => Rpk::where('status', 'draft')->count(),
            'rpkDisetujui' => Rpk::where('status', 'disetujui')->count(),
            'rpkDitolak' => Rpk::where('status', 'ditolak')->count(),
            'spkDraft' => Spk::where('status', 'draft')->count(),
            'spkDisetujui' => Spk::where('status', 'disetujui')->count(),
            'spkDitolak' => Spk::where('status', 'ditolak')->count(),
        ];
    }

    public function getAdminTingkatChart()
    {
        return [
            'universitas' => Spk::where('status', 'disetujui')->where('tingkat', 'Universitas')->count(),
            'regional' => Spk::where('status', 'disetujui')->where('tingkat', 'Regional')->count(),
            'nasional' => Spk::where('status', 'disetujui')->where('tingkat', 'Nasional')->count(),
            'internasional' => Spk::where('status', 'disetujui')->where('tingkat', 'Internasional')->count(),
        ];
    }

    public function getAdminKategoriChart()
    {
        $kategoriGrup = Spk::with('kegiatan')
            ->where('status', 'disetujui')
            ->get()
            ->groupBy(function ($spk) {
                return $spk->kegiatan->kategori ?? 'Lainnya';
            });

        return [
            'kategoriLabels' => $kategoriGrup->keys()->toArray(),
            'kategoriData' => $kategoriGrup->map->count()->values()->toArray(),
        ];
    }

    public function getTopMahasiswa()
    {
        $poinSendiri = Spk::where('status', 'disetujui')
            ->selectRaw('user_id, SUM(poin) as total')
            ->groupBy('user_id')
            ->pluck('total', 'user_id');

        $poinAnggota = Spk::selectRaw('kegiatan_user.user_id, SUM(spks.poin) as total')
            ->join('kegiatans', 'spks.kegiatan_id', '=', 'kegiatans.id')
            ->join('kegiatan_user', 'kegiatans.id', '=', 'kegiatan_user.kegiatan_id')
            ->where('spks.status', 'disetujui')
            ->groupBy('kegiatan_user.user_id')
            ->pluck('total', 'kegiatan_user.user_id');

        return User::role('Mahasiswa')->get()
            ->map(function ($user) use ($poinSendiri, $poinAnggota) {
                $user->total_poin = ($poinSendiri[$user->id] ?? 0) + ($poinAnggota[$user->id] ?? 0);
                return $user;
            })
            ->sortByDesc('total_poin')
            ->take(5);
    }

    public function getAktivitasTerbaru()
    {
        $aktivitasRpkMahasiswa = Rpk::with('user')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'aktor' => $item->user->name ?? '-',
                    'role' => 'Mahasiswa',
                    'kategori' => 'RPK',
                    'aktivitas' => 'Membuat RPK',
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                ];
            });

        $aktivitasSpkMahasiswa = Spk::with(['user', 'kegiatan'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'aktor' => $item->user->name ?? '-',
                    'role' => 'Mahasiswa',
                    'kategori' => 'SPK',
                    'aktivitas' => 'Mengajukan SPK : ' . ($item->kegiatan->kegiatan ?? '-'),
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                ];
            });

        $aktivitasRpkDosen = Rpk::with(['user.dosenPembimbing'])
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->latest('updated_at')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'aktor' => $item->user->dosenPembimbing->name ?? 'Dosen (Tidak Diketahui)',
                    'role' => 'Dosen',
                    'kategori' => 'RPK',
                    'aktivitas' => $item->status == 'disetujui'
                        ? 'Menyetujui RPK milik ' . ($item->user->name ?? '-')
                        : 'Menolak RPK milik ' . ($item->user->name ?? '-'),
                    'status' => $item->status,
                    'created_at' => $item->updated_at,
                ];
            });

        $aktivitasSpkDosen = Spk::with(['user.dosenPembimbing'])
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->latest('updated_at')
            ->take(10)
            ->get()
            ->map(function ($item) {
                return [
                    'aktor' => $item->user->dosenPembimbing->name ?? 'Dosen (Tidak Diketahui)',
                    'role' => 'Dosen',
                    'kategori' => 'SPK',
                    'aktivitas' => $item->status == 'disetujui'
                        ? 'Menyetujui SPK "' . ($item->kegiatan->kegiatan ?? '-') . '" milik ' . ($item->user->name ?? '-')
                        : 'Menolak SPK "' . ($item->kegiatan->kegiatan ?? '-') . '" milik ' . ($item->user->name ?? '-'),
                    'status' => $item->status,
                    'created_at' => $item->updated_at,
                ];
            });

        return collect()
            ->concat($aktivitasRpkMahasiswa)
            ->concat($aktivitasSpkMahasiswa)
            ->concat($aktivitasRpkDosen)
            ->concat($aktivitasSpkDosen)
            ->sortByDesc('created_at')
            ->take(10);
    }

    public function getDosenStats($dosenId)
    {
        $mahasiswaBimbinganIds = User::where('dosen_pembimbing_id', $dosenId)->pluck('id');

        return [
            'totalMahasiswa' => $mahasiswaBimbinganIds->count(),
            'rpkDraft' => Rpk::whereIn('user_id', $mahasiswaBimbinganIds)->where('status', 'draft')->count(),
            'rpkDisetujui' => Rpk::whereIn('user_id', $mahasiswaBimbinganIds)->where('status', 'disetujui')->count(),
            'rpkDitolak' => Rpk::whereIn('user_id', $mahasiswaBimbinganIds)->where('status', 'ditolak')->count(),
            'spkDraft' => Spk::whereIn('user_id', $mahasiswaBimbinganIds)->where('status', 'draft')->count(),
            'spkDisetujui' => Spk::whereIn('user_id', $mahasiswaBimbinganIds)->where('status', 'disetujui')->count(),
            'spkDitolak' => Spk::whereIn('user_id', $mahasiswaBimbinganIds)->where('status', 'ditolak')->count(),
        ];
    }

    public function getMahasiswaStats($userId)
    {
        $rpkDraft = Rpk::where('user_id', $userId)->where('status', 'draft')->count();
        $rpkDisetujui = Rpk::where('user_id', $userId)->where('status', 'disetujui')->count();
        $rpkDitolak = Rpk::where('user_id', $userId)->where('status', 'ditolak')->count();

        $spkDraft = Spk::where('user_id', $userId)->where('status', 'draft')->count();
        $spkDisetujui = Spk::where('user_id', $userId)->where('status', 'disetujui')->count();
        $spkDitolak = Spk::where('user_id', $userId)->where('status', 'ditolak')->count();

        $poinSendiri = Spk::where('user_id', $userId)
            ->where('status', 'disetujui')
            ->sum('poin');

        $poinAnggota = Spk::where('status', 'disetujui')
            ->whereHas('kegiatan.anggota', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->where('user_id', '!=', $userId)
            ->sum('poin');

        $totalPoin = $poinSendiri + $poinAnggota;
        $totalKegiatan = $rpkDisetujui + $spkDisetujui;
        $jumlahDitolak = $rpkDitolak + $spkDitolak;
        $totalSemua = $totalKegiatan + $jumlahDitolak;
        $persentase = $totalSemua > 0 ? round(($totalKegiatan / $totalSemua) * 100) : 0;

        return [
            'rpkDraft' => $rpkDraft,
            'rpkDisetujui' => $rpkDisetujui,
            'spkDraft' => $spkDraft,
            'spkDisetujui' => $spkDisetujui,
            'totalPoin' => $totalPoin,
            'totalKegiatan' => $totalKegiatan,
            'persentase' => $persentase,
            'jumlahDitolak' => $jumlahDitolak,
            'draft' => $rpkDraft + $spkDraft,
            'disetujui' => $rpkDisetujui + $spkDisetujui,
            'ditolak' => $rpkDitolak + $spkDitolak,
        ];
    }

    public function getMahasiswaTingkatChart($userId)
    {
        return [
            'universitas' => Spk::where('user_id', $userId)->where('status', 'disetujui')->where('tingkat', 'Universitas')->count(),
            'regional' => Spk::where('user_id', $userId)->where('status', 'disetujui')->where('tingkat', 'Regional')->count(),
            'nasional' => Spk::where('user_id', $userId)->where('status', 'disetujui')->where('tingkat', 'Nasional')->count(),
            'internasional' => Spk::where('user_id', $userId)->where('status', 'disetujui')->where('tingkat', 'Internasional')->count(),
        ];
    }

    public function getMahasiswaKategoriChart($userId)
    {
        $kegiatanUser = Kegiatan::whereHas('rpk', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });

        $kategori = (clone $kegiatanUser)
            ->selectRaw('kategori, COUNT(*) as total')
            ->groupBy('kategori')
            ->get();

        return [
            'kategoriLabels' => $kategori->pluck('kategori'),
            'kategoriData' => $kategori->pluck('total'),
        ];
    }

    public function getMahasiswaBulananChart($userId)
    {
        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $bulanData = [];

        for ($i = 1; $i <= 12; $i++) {
            $bulanData[] = Kegiatan::whereHas('rpk', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
                ->whereMonth('created_at', $i)
                ->count();
        }

        return compact('bulanLabels', 'bulanData');
    }

    public function getMahasiswaKegiatanTerbaru($userId)
    {
        return Kegiatan::whereHas('rpk', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->latest()->take(5)->get();
    }
}
