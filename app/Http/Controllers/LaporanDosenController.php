<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\User;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanDosenController extends Controller
{
    /**
     * Menerapkan semua filter
     */
    private function applyFilters($query, Request $request)
    {
        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('penyelenggara', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($user) use ($search) {
                        $user->where('name', 'like', "%{$search}%")
                            ->orWhere('nim', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kegiatan', function ($kegiatan) use ($search) {
                        $kegiatan->where('kegiatan', 'like', "%{$search}%");
                    });
            });
        }

        // Tahun
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Program Studi
        if ($request->filled('prodi')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('prodi', $request->prodi);
            });
        }

        // 🔧 PERBAIKAN: Tingkat dari SPKS, bukan kegiatans
        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        return $query;
    }

    /**
     * Halaman laporan
     */
    public function index(Request $request)
    {
        $dosenId = Auth::id();

        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            })
            ->where('status', 'disetujui');

        $query = $this->applyFilters($query, $request);

        $laporan = $query->latest()
            ->paginate(10)
            ->withQueryString();

        // Statistik
        $totalBimbingan = User::where('dosen_pembimbing_id', $dosenId)->count();

        $totalDisetujui = Spk::whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            })
            ->where('status', 'disetujui')
            ->count();

        $totalMenunggu = Spk::whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            })
            ->where('status', 'draft')
            ->count();

        // Dropdown Program Studi
        $programStudis = ProgramStudi::where('status', 'aktif')
            ->orderBy('nama_prodi')
            ->get();

        // 🔧 PERBAIKAN: Dropdown Tingkat dari SPKS
        $tingkatList = Spk::select('tingkat')
            ->distinct()
            ->whereNotNull('tingkat')
            ->orderBy('tingkat')
            ->pluck('tingkat');

        return view('dosen.laporan.index', compact(
            'laporan',
            'totalBimbingan',
            'totalDisetujui',
            'totalMenunggu',
            'programStudis',
            'tingkatList'
        ));
    }

    /**
     * Export Excel
     */
    public function export(Request $request)
    {
        $dosenId = Auth::id();

        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            })
            ->where('status', 'disetujui');

        $query = $this->applyFilters($query, $request);

        $laporan = $query->latest()->get();

        $fileName = 'laporan-prestasi-' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function () use ($laporan) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, [
                'Nama Mahasiswa',
                'NIM',
                'Program Studi',
                'Kegiatan',
                'Penyelenggara',
                'Tingkat',
                'Tahun',
                'Poin'
            ], ';');

            foreach ($laporan as $item) {
                fputcsv($file, [
                    $item->user->name ?? '',
                    $item->user->nim ?? '',
                    $item->user->prodi ?? '',
                    $item->kegiatan->kegiatan ?? '',
                    $item->penyelenggara ?? '',
                    $item->tingkat ?? '', // 🔧 PERBAIKAN: dari SPKS
                    $item->tahun,
                    $item->poin ?? 0, // 🔧 PERBAIKAN: dari SPKS langsung
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export PDF
     */
    public function exportPdf(Request $request)
    {
        $dosenId = Auth::id();

        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            })
            ->where('status', 'disetujui');

        $query = $this->applyFilters($query, $request);

        $laporan = $query->latest()->get();

        $dosen = Auth::user();

        $pdf = Pdf::loadView('dosen.laporan.pdf', compact('laporan', 'dosen'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('laporan.pdf');
    }
}