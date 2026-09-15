<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Spk;
use App\Models\User;
use App\Models\ProgramStudi;
use App\Services\LaporanService;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index(Request $request)
    {
        $query = Spk::with(['user', 'kegiatan.pointRule.scope', 'rpk.dosenPembimbing'])
            ->where('status', 'disetujui');

        $query = $this->laporanService->applyFilters($query, $request);

        $laporan = $query->latest()->paginate(10)->withQueryString();

        $prodis = ProgramStudi::where('status', 'aktif')->orderBy('nama_prodi')->get();

        $ruangLingkupList = Spk::where('status', 'disetujui')
            ->join('kegiatans', 'spks.kegiatan_id', '=', 'kegiatans.id')
            ->join('point_rules', 'kegiatans.point_rule_id', '=', 'point_rules.id')
            ->join('activity_scopes', 'point_rules.scope_id', '=', 'activity_scopes.id')
            ->select('activity_scopes.name as ruang_lingkup')
            ->distinct()
            ->whereNotNull('activity_scopes.name')
            ->orderBy('activity_scopes.name')
            ->pluck('ruang_lingkup');

        return view('admin.laporan.index', array_merge(
            compact('laporan', 'prodis', 'ruangLingkupList'),
            [
                'totalMahasiswa' => User::role('Mahasiswa')->count(),
                'totalDosen' => User::role('Dosen')->count(),
                'totalSpk' => Spk::count(),
                'totalPrestasi' => Spk::where('status', 'disetujui')->count(),
            ]
        ));
    }

    public function export(Request $request)
    {
        $query = Spk::with(['user', 'kegiatan.pointRule.scope', 'rpk.dosenPembimbing'])
            ->where('status', 'disetujui');

        $query = $this->laporanService->applyFilters($query, $request);
        $laporan = $query->get();

        $fileName = 'laporan-prestasi-mahasiswa-isi-yk.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $csvHeaders = [
            'Nama', 'NIM', 'Prodi', 'Judul Kegiatan', 'Nama Kegiatan',
            'Penyelenggara', 'Ruang Lingkup', 'Peran/Sifat', 'Poin', 'Tanggal Kegiatan'
        ];

        $mapper = function ($item) {
            return [
                $item->user->name ?? '',
                $item->user->nim ?? '',
                $item->user->prodi ?? '',
                $item->judul_kegiatan ?? $item->kegiatan?->judul_kegiatan ?? $item->kegiatan?->kegiatan ?? '',
                $item->kegiatan?->kegiatan ?? '',
                $item->penyelenggara ?? '',
                $item->kegiatan?->pointRule?->scope?->name ?? '',
                $item->peran_sifat ?? '',
                $item->poin ?? 0,
                $this->laporanService->getTanggalSelesai($item),
            ];
        };

        $callback = $this->laporanService->generateCsv($laporan, $csvHeaders, $mapper);

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $query = Spk::with(['user', 'rpk.dosenPembimbing', 'kegiatan.pointRule.scope'])
            ->where('status', 'disetujui');

        $query = $this->laporanService->applyFilters($query, $request);
        $laporan = $query->get();

        return $this->laporanService->generatePdf($laporan, 'admin.laporan.pdf')
            ->download('laporan-prestasi-mahasiswa-isi-yk.pdf');
    }

    public function exportExcel(Request $request)
    {
        try {
            $query = Spk::with(['user', 'rpk.dosenPembimbing', 'kegiatan.pointRule.scope'])
                ->where('status', 'disetujui');

            $query = $this->laporanService->applyFilters($query, $request);
            $laporan = $query->get();

            $spreadsheet = $this->laporanService->generateExcel($laporan);

            $fileName = 'laporan-prestasi-mahasiswa-' . date('d-m-Y') . '.xlsx';

            return response()->streamDownload(function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        } catch (\Exception $e) {
            \Log::error('Export Excel Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return back()->with('error', 'Gagal export Excel: ' . $e->getMessage());
        }
    }
}


