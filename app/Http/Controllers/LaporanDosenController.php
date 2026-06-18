<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanDosenController extends Controller
{
    /**
     * Helper Method: Menerapkan filter pencarian
     */
    private function applyFilters($query, Request $request)
    {
        // 1. Filter Pencarian Global (Nama, NIM, Kegiatan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                // Cari di tabel SPK
                $q->where('penyelenggara', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  
                  // Cari di tabel User (Nama/NIM Mahasiswa)
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('nim', 'like', "%{$search}%");
                  })
                  
                  // Cari di tabel Kegiatan
                  ->orWhereHas('kegiatan', function ($kegiatanQuery) use ($search) {
                      $kegiatanQuery->where('kegiatan', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Filter Status SPK
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 3. Filter Tahun Pengajuan SPK
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        return $query;
    }

    /**
     * Menampilkan halaman index laporan dosen
     */
    public function index(Request $request)
    {
        $dosenId = Auth::id();

        // Base Query: Ambil SPK yang HANYA milik mahasiswa bimbingannya
        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            });

        // Terapkan filter dari helper
        $query = $this->applyFilters($query, $request);

        // Ambil data untuk tabel dengan pagination
        $laporan = $query->latest()->paginate(10)->withQueryString();

        // -----------------------------------------------------
        // Menghitung Statistik untuk Kartu Ringkasan (Cards)
        // -----------------------------------------------------
        $totalBimbingan = User::where('dosen_pembimbing_id', $dosenId)->count();
        
        $totalDisetujui = Spk::whereHas('user', function($q) use ($dosenId) {
            $q->where('dosen_pembimbing_id', $dosenId);
        })->where('status', 'disetujui')->count();

        $totalMenunggu = Spk::whereHas('user', function($q) use ($dosenId) {
            $q->where('dosen_pembimbing_id', $dosenId);
        })->where('status', 'draft')->count();

        // Return ke view yang telah kita buat sebelumnya
        return view('dosen.laporan.index', compact(
            'laporan',
            'totalBimbingan',
            'totalDisetujui',
            'totalMenunggu'
        ));
    }

    /**
     * Export data ke Excel / CSV
     */
    public function export(Request $request)
    {
        $dosenId = Auth::id();

        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            });

        $query = $this->applyFilters($query, $request);
        $laporan = $query->latest()->get();

        $fileName = 'laporan-prestasi-bimbingan-' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () use ($laporan) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM agar rapi di Microsoft Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header kolom Excel
            fputcsv($file, [
                'Nama Mahasiswa',
                'NIM',
                'Nama Kegiatan',
                'Penyelenggara',
                'Tingkat',
                'Tahun',
                'Poin',
                'Status'
            ], ';');

            // Isi Data
            foreach ($laporan as $item) {
                fputcsv($file, [
                    $item->user->name ?? '',
                    $item->user->nim ?? '',
                    $item->kegiatan->kegiatan ?? '',
                    $item->penyelenggara ?? '',
                    $item->kegiatan->tingkat ?? '',
                    $item->tahun ?? '',
                    $item->kegiatan->masterKegiatan->poin ?? 0,
                    strtoupper($item->status)
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data ke PDF
     */
    public function exportPdf(Request $request)
    {
        $dosenId = Auth::id();

        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            });

        $query = $this->applyFilters($query, $request);
        $laporan = $query->latest()->get();
        $dosen = Auth::user(); // Untuk mencetak nama dosen di kop surat PDF

        // Pastikan Anda sudah membuat view 'dosen.laporan.pdf' untuk format cetaknya
        $pdf = Pdf::loadView('dosen.laporan.pdf', compact('laporan', 'dosen'));

        // Atur ukuran kertas
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Laporan-Prestasi-Bimbingan-' . date('Y-m-d') . '.pdf');
    }
}