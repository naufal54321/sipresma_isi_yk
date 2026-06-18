<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProgramStudi;

class LaporanController extends Controller
{
    /**
     * FUNGSI HELPER: Menerapkan semua filter pencarian
     * Memisahkan fungsi ini agar tidak perlu menulis ulang logika yang sama
     * di method index, export, dan exportPdf.
     */
    private function applyFilters($query, Request $request)
    {
        // 1. Filter Global (Pencarian ke Banyak Kolom)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Cari di tabel utama (SPK)
                $q->where('penyelenggara', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%")
                  
                  // Cari di tabel relasi User (Nama & NIM)
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('nim', 'like', "%{$search}%");
                  })
                  
                  // Cari di tabel relasi Kegiatan
                  ->orWhereHas('kegiatan', function ($kegiatanQuery) use ($search) {
                      $kegiatanQuery->where('kegiatan', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Filter Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        // 3. Filter Program Studi
        if ($request->filled('prodi')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('prodi', $request->prodi);
            });
        }

        // 4. Filter Tingkat
        if ($request->filled('tingkat')) {
            $query->whereHas('kegiatan', function ($q) use ($request) {
                $q->where('tingkat', $request->tingkat);
            });
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = Spk::with([
            'user',
            'kegiatan.masterKegiatan'
        ])->where('status', 'disetujui');

        // Panggil fungsi helper untuk filter
        $query = $this->applyFilters($query, $request);

        $laporan = $query
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Mempertahankan parameter filter di URL pagination

        $prodis = ProgramStudi::where('status', 'aktif')
            ->orderBy('nama_prodi')
            ->get();

        $totalMahasiswa = User::role('Mahasiswa')->count();
        $totalDosen = User::role('Dosen')->count();
        $totalSpk = Spk::count();
        $totalPrestasi = Spk::where('status', 'disetujui')->count();

        return view('admin.laporan.index', compact(
            'laporan',
            'prodis',
            'totalMahasiswa',
            'totalDosen',
            'totalSpk',
            'totalPrestasi'
        ));
    }

    public function export(Request $request)
    {
        $query = Spk::with([
            'user',
            'kegiatan.masterKegiatan'
        ])->where('status', 'disetujui');

        // Panggil fungsi helper untuk filter
        $query = $this->applyFilters($query, $request);

        $laporan = $query->get();

        $fileName = 'laporan-prestasi-mahasiswa-isi-yk.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () use ($laporan) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM agar bisa dibaca dengan baik di Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, [
                'Nama',
                'NIM',
                'Prodi',
                'Kegiatan',
                'Penyelenggara',
                'Tingkat',
                'Poin',
                'Tanggal'
            ], ';');

            foreach ($laporan as $item) {
                fputcsv($file, [
                    $item->user->name ?? '',
                    $item->user->nim ?? '',
                    $item->user->prodi ?? '',
                    $item->kegiatan->kegiatan ?? '',
                    $item->penyelenggara ?? '',
                    $item->kegiatan->tingkat ?? '',
                    $item->kegiatan->masterKegiatan->poin ?? 0,
                    $item->created_at->format('d-m-Y')
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Spk::with([
            'user',
            'kegiatan.masterKegiatan'
        ])->where('status', 'disetujui');

        // Panggil fungsi helper untuk filter
        $query = $this->applyFilters($query, $request);

        $laporan = $query->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('laporan'));

        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-prestasi-mahasiswa-isi-yk.pdf');
    }
}