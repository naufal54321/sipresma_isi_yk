<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProgramStudi;
use Carbon\Carbon;

class LaporanController extends Controller
{
    /**
     * FUNGSI HELPER: Menerapkan semua filter pencarian
     */
    private function applyFilters($query, Request $request)
    {
        // 1. Filter Global (Pencarian ke Banyak Kolom)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('penyelenggara', 'like', "%{$search}%")
                  ->orWhere('hasil', 'like', "%{$search}%")
                  ->orWhere('judul_kegiatan', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('nim', 'like', "%{$search}%");
                  })
                  ->orWhereHas('kegiatan', function ($kegiatanQuery) use ($search) {
                      $kegiatanQuery->where('kegiatan', 'like', "%{$search}%")
                                    ->orWhere('judul_kegiatan', 'like', "%{$search}%");
                  });
            });
        }

        // 2. FILTER TAHUN
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // 3. Filter Program Studi
        if ($request->filled('prodi')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('prodi', $request->prodi);
            });
        }

        // 🔧 4. Filter Tingkat (dari SPK, bukan kegiatan)
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->where('status', 'disetujui');

        $query = $this->applyFilters($query, $request);

        $laporan = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $prodis = ProgramStudi::where('status', 'aktif')
            ->orderBy('nama_prodi')
            ->get();

        // 🔧 Dropdown Tingkat dari SPK
        $tingkatList = Spk::select('tingkat')
            ->distinct()
            ->whereNotNull('tingkat')
            ->orderBy('tingkat')
            ->pluck('tingkat');

        $totalMahasiswa = User::role('Mahasiswa')->count();
        $totalDosen = User::role('Dosen')->count();
        $totalSpk = Spk::count();
        $totalPrestasi = Spk::where('status', 'disetujui')->count();

        return view('admin.laporan.index', compact(
            'laporan',
            'prodis',
            'tingkatList',
            'totalMahasiswa',
            'totalDosen',
            'totalSpk',
            'totalPrestasi'
        ));
    }

    public function export(Request $request)
    {
        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->where('status', 'disetujui');

        $query = $this->applyFilters($query, $request);

        $laporan = $query->get();

        $fileName = 'laporan-prestasi-mahasiswa-isi-yk.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () use ($laporan) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Nama',
                'NIM',
                'Prodi',
                'Judul Kegiatan',
                'Nama Kegiatan',
                'Penyelenggara',
                'Tingkat',
                'Hasil',
                'Poin',
                'Tanggal Kegiatan'
            ], ';');

            foreach ($laporan as $item) {
                fputcsv($file, [
                    $item->user->name ?? '',
                    $item->user->nim ?? '',
                    $item->user->prodi ?? '',
                    $item->judul_kegiatan ?? $item->kegiatan->judul_kegiatan ?? $item->kegiatan->kegiatan ?? '',
                    $item->kegiatan->kegiatan ?? '',
                    $item->penyelenggara ?? '',
                    $item->tingkat ?? '', // 🔧 DARI SPK
                    $item->hasil ?? '', // 🔧 DARI SPK
                    $item->poin ?? 0, // 🔧 DARI SPK
                    $item->tanggal_kegiatan ? Carbon::parse($item->tanggal_kegiatan)->format('d-m-Y') : '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->where('status', 'disetujui');

        $query = $this->applyFilters($query, $request);

        $laporan = $query->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('laporan'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-prestasi-mahasiswa-isi-yk.pdf');
    }
}