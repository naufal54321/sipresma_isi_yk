<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Prestasi Mahasiswa - Institut Seni Indonesia Yogyakarta</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 15mm 20mm;
            @bottom-right {
                content: "Halaman " counter(page) " dari " counter(pages);
                font-family: "Times New Roman", Times, serif;
                font-size: 10pt;
                color: #000000;
            }
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 11pt;
            color: #000000;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #000000;
            position: relative;
        }
        .kop-surat::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            border-bottom: 1px solid #000000;
        }
        .kop-surat h2 { margin: 0; font-size: 14pt; font-weight: normal; }
        .kop-surat h1 { margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat p { margin: 2px 0 0 0; font-size: 10pt; }

        .judul-dokumen {
            text-align: center;
            margin-bottom: 25px;
        }
        .judul-dokumen h3 { margin: 0; font-size: 12pt; font-weight: bold; text-transform: uppercase; text-decoration: underline; }
        .judul-dokumen p { margin: 5px 0 0 0; font-size: 11pt; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        tr { page-break-inside: avoid; }
        th, td {
            padding: 5px 6px;
            border: 1px solid #000000;
            text-align: left;
            vertical-align: top;
            font-size: 10pt;
        }
        th {
            background-color: #ffffff;
            color: #000000;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            font-size: 10pt;
        }

        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</h2>
        <h1>Institut Seni Indonesia Yogyakarta</h1>
        <p>Jalan Parangtritis Km. 6,5 Sewon, Bantul, Yogyakarta 55188</p>
        <p>Telepon: (0274) 379133, 373659 | Laman: www.isi.ac.id</p>
    </div>

    <div class="judul-dokumen">
        <h3>Laporan Prestasi Mahasiswa</h3>
        <p>Sistem Informasi Prestasi Mahasiswa (SIPRESMA)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%">No</th>
                <th style="width: 13%">Nama Mahasiswa</th>
                <th style="width: 8%">NIM</th>
                <th style="width: 10%">Program Studi</th>
                <th style="width: 14%">Judul Kegiatan</th>
                <th style="width: 14%">Nama Kegiatan</th>
                <th style="width: 10%">Tingkat</th>
                <th style="width: 8%">Hasil</th>
                <th style="width: 5%">Poin</th>
                <th style="width: 7%">Tanggal</th>
                <th style="width: 8%">Tahun</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td class="text-center">{{ $item->user->nim ?? '-' }}</td>
                <td>{{ $item->user->prodi ?? '-' }}</td>
                {{-- 🔧 JUDUL KEGIATAN --}}
                <td>{{ $item->judul_kegiatan ?? $item->kegiatan->judul_kegiatan ?? $item->kegiatan->kegiatan ?? '-' }}</td>
                <td>{{ $item->kegiatan->kegiatan ?? '-' }}</td>
                {{-- 🔧 TINGKAT DARI SPK --}}
                <td class="text-center">{{ $item->tingkat ?? '-' }}</td>
                {{-- 🔧 HASIL DARI SPK --}}
                <td class="text-center">{{ $item->hasil ?? '-' }}</td>
                {{-- 🔧 POIN DARI SPK --}}
                <td class="text-center font-bold">{{ $item->poin ?? 0 }}</td>
                <td class="text-center">
                    {{ $item->tanggal_kegiatan ? \Carbon\Carbon::parse($item->tanggal_kegiatan)->format('d/m/Y') : '-' }}
                </td>
                <td class="text-center">{{ $item->tahun ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center" style="padding: 20px;">Belum ada data prestasi yang dapat dicetak.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>