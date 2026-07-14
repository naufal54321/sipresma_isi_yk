<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\User;
use App\Models\ProgramStudi;
use App\Services\LaporanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanDosenController extends Controller
{
    protected $laporanService;

    public function __construct(LaporanService $laporanService)
    {
        $this->laporanService = $laporanService;
    }

    public function index(Request $request)
    {
        $dosenId = Auth::id();

        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            })
            ->where('status', 'disetujui');

        $query = $this->laporanService->applyFilters($query, $request);

        if ($request->filled('fakultas')) {
            $allData = $query->get();
            $filteredIds = $allData->filter(function ($item) use ($request) {
                return $this->laporanService->getFakultasFromProdi($item->user->prodi) === $request->fakultas;
            })->pluck('id');
            $query->whereIn('id', $filteredIds);
        }

        $laporan = $query->latest()->paginate(10)->withQueryString();

        return view('dosen.laporan.index', array_merge(
            compact('laporan'),
            [
                'totalBimbingan' => User::where('dosen_pembimbing_id', $dosenId)->count(),
                'totalDisetujui' => Spk::whereHas('user', fn($q) => $q->where('dosen_pembimbing_id', $dosenId))->where('status', 'disetujui')->count(),
                'totalMenunggu' => Spk::whereHas('user', fn($q) => $q->where('dosen_pembimbing_id', $dosenId))->where('status', 'draft')->count(),
                'programStudis' => ProgramStudi::where('status', 'aktif')->orderBy('nama_prodi')->get(),
                'fakultasList' => ProgramStudi::select('fakultas')->distinct()->whereNotNull('fakultas')->orderBy('fakultas')->pluck('fakultas'),
                'tingkatList' => Spk::select('tingkat')->distinct()->whereNotNull('tingkat')->orderBy('tingkat')->pluck('tingkat'),
            ]
        ));
    }

    public function export(Request $request)
    {
        $dosenId = Auth::id();

        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            })->where('status', 'disetujui');

        $query = $this->laporanService->applyFilters($query, $request);

        if ($request->filled('fakultas')) {
            $allData = $query->get();
            $filteredIds = $allData->filter(function ($item) use ($request) {
                return $this->laporanService->getFakultasFromProdi($item->user->prodi) === $request->fakultas;
            })->pluck('id');
            $query->whereIn('id', $filteredIds);
        }

        $laporan = $query->latest()->get();

        $fileName = 'laporan-prestasi-' . date('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $csvHeaders = [
            'Nama Mahasiswa', 'NIM', 'Prodi', 'Fakultas',
            'Judul Kegiatan', 'Nama Kegiatan', 'Penyelenggara',
            'Tingkat', 'Hasil', 'Poin', 'Tanggal Kegiatan'
        ];

        $mapper = function ($item) {
            return [
                $item->user->name ?? '',
                $item->user->nim ?? '',
                $item->user->prodi ?? '',
                $this->laporanService->getFakultasFromProdi($item->user->prodi),
                $item->judul_kegiatan ?? $item->kegiatan->kegiatan ?? '',
                $item->kegiatan->kegiatan ?? '',
                $item->penyelenggara ?? '',
                $item->tingkat ?? '',
                $item->hasil ?? '',
                $item->poin ?? 0,
                $this->laporanService->getTanggalSelesai($item),
            ];
        };

        $callback = $this->laporanService->generateCsv($laporan, $csvHeaders, $mapper);

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        try {
            $dosenId = Auth::id();
            $dosen = Auth::user();

            $query = Spk::with(['user.dosenPembimbing', 'kegiatan.masterKegiatan'])
                ->whereHas('user', function ($q) use ($dosenId) {
                    $q->where('dosen_pembimbing_id', $dosenId);
                })->where('status', 'disetujui');

            $query = $this->laporanService->applyFilters($query, $request);
            $laporan = $query->latest()->get();

            $spreadsheet = $this->laporanService->generateExcelDosen($laporan, $dosen->name);

            $fileName = 'laporan-prestasi-dosen-' . date('d-m-Y') . '.xlsx';

            return response()->streamDownload(function () use ($spreadsheet) {
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
            }, $fileName, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        } catch (\Exception $e) {
            \Log::error('Export Excel Dosen Error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return back()->with('error', 'Gagal export Excel: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $dosenId = Auth::id();

        $query = Spk::with(['user', 'kegiatan.masterKegiatan'])
            ->whereHas('user', function ($q) use ($dosenId) {
                $q->where('dosen_pembimbing_id', $dosenId);
            })->where('status', 'disetujui');

        $query = $this->laporanService->applyFilters($query, $request);

        if ($request->filled('fakultas')) {
            $allData = $query->get();
            $filteredIds = $allData->filter(function ($item) use ($request) {
                return $this->laporanService->getFakultasFromProdi($item->user->prodi) === $request->fakultas;
            })->pluck('id');
            $query->whereIn('id', $filteredIds);
        }

        $laporan = $query->latest()->get();
        $dosen = Auth::user();

        return $this->laporanService->generatePdf($laporan, 'dosen.laporan.pdf', ['dosen' => $dosen])
            ->download('laporan.pdf');
    }
}
