<?php

namespace App\Services;

use App\Models\Spk;
use App\Models\ProgramStudi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class LaporanService
{
    public function applyFilters($query, $request)
    {
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

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('prodi')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('prodi', $request->prodi);
            });
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        return $query;
    }

    public function getTanggalSelesai($item)
    {
        if ($item->kegiatan && $item->kegiatan->tanggal_selesai) {
            return Carbon::parse($item->kegiatan->tanggal_selesai)->translatedFormat('d F Y');
        }

        if ($item->kegiatan && $item->kegiatan->tanggal_mulai) {
            return Carbon::parse($item->kegiatan->tanggal_mulai)->translatedFormat('d F Y');
        }

        return '-';
    }

    public function getFakultasFromProdi($prodiName)
    {
        static $cache = [];
        if (!isset($cache[$prodiName])) {
            $programStudi = ProgramStudi::where('nama_prodi', $prodiName)->first();
            $cache[$prodiName] = $programStudi->fakultas ?? 'Fakultas Lainnya';
        }
        return $cache[$prodiName];
    }

    public function getHeaderColor($fakultasName)
    {
        $fakultasLower = strtolower($fakultasName);

        if (strpos($fakultasLower, 'seni rupa dan desain') !== false) {
            return '2471A3';
        } elseif (strpos($fakultasLower, 'seni pertunjukan') !== false && strpos($fakultasLower, 'desain') === false) {
            return 'F4A460';
        } elseif (strpos($fakultasLower, 'media rekam') !== false) {
            return 'FFFF00';
        } else {
            return '1a5276';
        }
    }

    public function getHeaderFontColor($fakultasName)
    {
        $fakultasLower = strtolower($fakultasName);

        if ((strpos($fakultasLower, 'seni rupa') !== false && strpos($fakultasLower, 'desain') === false)
            || strpos($fakultasLower, 'media rekam') !== false) {
            return '000000';
        } else {
            return 'FFFFFF';
        }
    }

    public function getHeaderFontColorDosen($fakultasName)
    {
        $fakultasLower = strtolower($fakultasName);

        if (strpos($fakultasLower, 'seni pertunjukan') !== false
            || strpos($fakultasLower, 'media rekam') !== false) {
            return '000000';
        } else {
            return 'FFFFFF';
        }
    }

    public function createSheet($spreadsheet, $sheetName, $data, $fakultasName = null, $dosenName = null)
    {
        if ($spreadsheet->getSheetCount() == 1 && $spreadsheet->getActiveSheet()->getCell('A1') == '') {
            $sheet = $spreadsheet->getActiveSheet();
        } else {
            $sheet = $spreadsheet->createSheet();
        }

        $sheet->setTitle($sheetName);

        $headerBgColor = $this->getHeaderColor($fakultasName);
        $headerFontColor = $dosenName
            ? $this->getHeaderFontColorDosen($fakultasName)
            : $this->getHeaderFontColor($fakultasName);

        $judulStyle = [
            'font' => [
                'bold' => true,
                'name' => 'Arial',
                'size' => 12,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '800000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->setCellValue('A1', 'LAPORAN PRESTASI MAHASISWA ISI YOGYAKARTA');
        $sheet->mergeCells('A1:P1');
        $sheet->getStyle('A1')->applyFromArray($judulStyle);
        $sheet->getRowDimension(1)->setRowHeight(30);

        $sheet->mergeCells('A2:P2');

        if ($dosenName) {
            $sheet->setCellValue('A2', 'Dosen Pembimbing: ' . $dosenName);
            $sheet->getStyle('A2')->getFont()->setBold(true)->setName('Arial')->setSize(11);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        }

        $subJudul = $fakultasName ? strtoupper($fakultasName) : 'LAPORAN PRESTASI MAHASISWA';
        $sheet->setCellValue('A3', $subJudul);
        $sheet->mergeCells('A3:P3');
        $sheet->getStyle('A3')->getFont()->setBold(true)->setName('Arial')->setSize(11);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 11,
                'name' => 'Arial',
                'color' => ['rgb' => $headerFontColor],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => $headerBgColor],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];

        $dataStyle = [
            'font' => ['size' => 10, 'name' => 'Arial'],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $centerStyle = array_merge($dataStyle, [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        $headers = [
            'No', 'Waktu Perolehan Prestasi', 'Capaian/Peringkat/Penghargaan', 'Kategori',
            'Nama', 'Program Studi', 'Angkatan/Semester', 'Email', 'Dosen Pembimbing/Pendamping',
            'Judul Karya/Inovasi/Riset/Prestasi', 'Biografi/Latar Belakang', 'Rincian Inovasi/Riset/Prestasi',
            'Kebaruan/Keunggulan', 'Nama Ajang/Kegiatan', 'Penyelenggara', 'Tingkat Kegiatan',
        ];

        $columns = range('A', 'P');
        $headerRow = 4;
        foreach ($headers as $index => $header) {
            $sheet->setCellValue($columns[$index] . $headerRow, $header);
        }

        $sheet->getStyle('A4:P4')->applyFromArray($headerStyle);
        $sheet->getRowDimension(4)->setRowHeight(35);

        $row = 5;
        $no = 1;

        foreach ($data as $item) {
            $user = $item->user;

            $nama = ($user->name ?? '-') . ' (' . ($user->nim ?? '-') . ')';
            $prodi = $user->prodi ?? '-';
            $email = $user->email ?? '-';

            $angkatan = $user->angkatan ?? '';
            $semester = $user->semester ?? '';
            $angkatanSemester = trim($angkatan . ($semester ? ' / Semester ' . $semester : ''));
            if (empty($angkatanSemester)) $angkatanSemester = '-';

            $dosenPembimbing = '-';
            if ($user->dosenPembimbing) {
                $dosenPembimbing = $user->dosenPembimbing->name;
            }

            $judulKegiatan = $item->judul_kegiatan
                ?? $item->kegiatan->judul_kegiatan
                ?? $item->kegiatan->kegiatan
                ?? '-';

            $namaKegiatan = $item->kegiatan->kegiatan ?? '-';
            $penyelenggara = $item->penyelenggara ?? '-';
            $tingkat = $item->tingkat ?? '-';
            $hasil = $item->hasil ?? '-';

            $tanggal = $this->getTanggalSelesai($item);

            $kategori = $item->kegiatan->kategori
                ?? $item->kegiatan->masterKegiatan->kategori
                ?? 'Prestasi';

            $rowData = [
                $no++, $tanggal, $hasil, $kategori, $nama, $prodi, $angkatanSemester,
                $email, $dosenPembimbing, $item->judul_karya ?? '-',
                $item->biografi ?? '-', $item->rincian ?? '-', $item->kebaruan ?? '-',
                $judulKegiatan, $penyelenggara, $tingkat,
            ];

            foreach ($rowData as $index => $value) {
                $sheet->setCellValue($columns[$index] . $row, $value);
            }

            $sheet->getStyle('A' . $row . ':P' . $row)->applyFromArray($dataStyle);

            $centerColumns = ['A', 'B', 'C', 'G', 'P'];
            foreach ($centerColumns as $col) {
                $sheet->getStyle($col . $row)->applyFromArray($centerStyle);
            }

            $row++;
        }

        foreach ($columns as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(25);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(30);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(30);

        $sheet->freezePane('A5');

        return $sheet;
    }

    public function generateExcel($laporan)
    {
        $groupedByFakultas = [];
        foreach ($laporan as $item) {
            $fakultas = $this->getFakultasFromProdi($item->user->prodi ?? '');
            if (!isset($groupedByFakultas[$fakultas])) {
                $groupedByFakultas[$fakultas] = [];
            }
            $groupedByFakultas[$fakultas][] = $item;
        }

        ksort($groupedByFakultas);

        $spreadsheet = new Spreadsheet();

        $sheetIndex = 0;
        foreach ($groupedByFakultas as $fakultasName => $dataFakultas) {
            $sheetName = substr($fakultasName, 0, 31);
            $this->createSheet($spreadsheet, $sheetName, $dataFakultas, $fakultasName);
            $sheetIndex++;
        }

        if ($spreadsheet->getSheetCount() > count($groupedByFakultas)) {
            $spreadsheet->removeSheetByIndex($spreadsheet->getSheetCount() - 1);
        }

        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }

    public function generateExcelDosen($laporan, $dosenName)
    {
        $groupedByFakultas = [];
        foreach ($laporan as $item) {
            $fakultas = $this->getFakultasFromProdi($item->user->prodi ?? '');
            if (!isset($groupedByFakultas[$fakultas])) {
                $groupedByFakultas[$fakultas] = [];
            }
            $groupedByFakultas[$fakultas][] = $item;
        }

        ksort($groupedByFakultas);

        $spreadsheet = new Spreadsheet();

        foreach ($groupedByFakultas as $fakultasName => $dataFakultas) {
            $sheetName = substr($fakultasName, 0, 31);
            $this->createSheet($spreadsheet, $sheetName, $dataFakultas, $fakultasName, $dosenName);
        }

        if ($spreadsheet->getSheetCount() > count($groupedByFakultas)) {
            $spreadsheet->removeSheetByIndex($spreadsheet->getSheetCount() - 1);
        }

        $spreadsheet->setActiveSheetIndex(0);

        return $spreadsheet;
    }

    public function generatePdf($laporan, $viewName, $extraData = [])
    {
        $pdf = Pdf::loadView($viewName, array_merge(['laporan' => $laporan], $extraData))
            ->setPaper('A4', 'landscape');

        return $pdf;
    }

    public function generateCsv($laporan, $headers, $mapper)
    {
        $callback = function () use ($laporan, $headers, $mapper) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, $headers, ';');

            foreach ($laporan as $item) {
                fputcsv($file, $mapper($item), ';');
            }

            fclose($file);
        };

        return $callback;
    }
}
