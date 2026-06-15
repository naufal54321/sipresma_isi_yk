<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanPrestasiExport;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ProgramStudi;

class LaporanController extends Controller
{

public function index(Request $request)
{
    $query = Spk::with([
        'user',
        'kegiatan.masterKegiatan'
    ])
    ->where('status', 'disetujui');

    // Filter Nama
if ($request->filled('nama')) {
    $query->whereHas('user', function ($q) use ($request) {
        $q->where('name', 'like', '%' . $request->nama . '%');
    });
}

    // Filter Tahun
    if ($request->filled('tahun')) {
        $query->whereYear('created_at', $request->tahun);
    }

    // Filter Prodi
    if ($request->filled('prodi')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('prodi', $request->prodi);
        });
    }

    $laporan = $query
        ->latest()
        ->paginate(10)
        ->withQueryString();

    // Dropdown Prodi
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
    ])
    ->where('status', 'disetujui');

   // Filter Nama
if ($request->filled('nama')) {
    $query->whereHas('user', function ($q) use ($request) {
        $q->where('name', 'like', '%' . $request->nama . '%');
    });
}

    // Filter Tahun
    if ($request->filled('tahun')) {
        $query->whereYear('created_at', $request->tahun);
    }

    // Filter Prodi
    if ($request->filled('prodi')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('prodi', $request->prodi);
        });
    }

    $laporan = $query->get();

    $fileName = 'laporan-prestasi-mahasiswa-isi-yk.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="'.$fileName.'"',
    ];

    $callback = function () use ($laporan) {

    $file = fopen('php://output', 'w');

    fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

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
    ])
    ->where('status', 'disetujui');

    if ($request->filled('tahun')) {
        $query->whereYear('created_at', $request->tahun);
    }

    if ($request->filled('prodi')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('prodi', $request->prodi);
        });
    }

    if ($request->filled('nama')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->nama . '%');
        });
    }

    $laporan = $query->get();

    $pdf = Pdf::loadView(
        'admin.laporan.pdf',
        compact('laporan')
    );

    $pdf->setPaper('A4', 'landscape');

    return $pdf->download('laporan-prestasi-mahasiswa-isi-yk.pdf');
}
}