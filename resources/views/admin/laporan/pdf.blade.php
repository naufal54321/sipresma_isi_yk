<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Prestasi Mahasiswa - Institut Seni Indonesia Yogyakarta</title>
    <style>
        /* Pengaturan Halaman */
        @page {
            size: A4 landscape;
            margin: 15mm 20mm;
            
            /* Penomoran halaman otomatis */
            @bottom-right {
                content: "Halaman " counter(page) " dari " counter(pages);
                font-family: "Times New Roman", Times, serif;
                font-size: 10pt;
                color: #000000;
            }
        }

        /* Tipografi Umum Baku (Resmi) */
        body {
            font-family: "Times New Roman", Times, serif; /* Standar dokumen resmi */
            font-size: 11pt;
            color: #000000;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        /* Kop Surat */
        .kop-surat {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #000000;
            position: relative;
        }
        /* Garis ganda di bawah kop surat */
        .kop-surat::after {
            content: "";
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            border-bottom: 1px solid #000000;
        }
        .kop-surat h2 {
            margin: 0;
            font-size: 14pt;
            font-weight: normal;
        }
        .kop-surat h1 {
            margin: 0;
            font-size: 16pt;
            font-weight: bold;
            text-transform: uppercase;
        }
        .kop-surat p {
            margin: 2px 0 0 0;
            font-size: 10pt;
        }

        /* Judul Laporan */
        .judul-dokumen {
            text-align: center;
            margin-bottom: 25px;
        }
        .judul-dokumen h3 {
            margin: 0;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
        }
        .judul-dokumen p {
            margin: 5px 0 0 0;
            font-size: 11pt;
        }

        /* Desain Tabel Resmi */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        tr {
            page-break-inside: avoid;
        }

        th, td {
            padding: 6px 8px; /* Padding sedikit dirapatkan */
            border: 1px solid #000000; /* Border hitam tegas */
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #ffffff;
            color: #000000;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            font-size: 10.5pt;
        }

        /* Tanda Tangan */
        .tanda-tangan {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .tanda-tangan-box {
            float: right;
            width: 300px;
            text-align: left;
        }
        .clear {
            clear: both;
        }

        /* Class Bantuan */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</h2>
        <h1>Institut Seni Indonesia Yogyakarta</h1>
        <p>Jalan Parangtritis Km. 6,5 Sewon, Bantul, Yogyakarta 55188</p>
        <p>Telepon: (0274) 379133, 373659 | Laman: www.isi.ac.id </p>
    </div>

    <div class="judul-dokumen">
        <h3>Laporan Prestasi Mahasiswa</h3>
        <p>Sistem Informasi Prestasi Mahasiswa (SIPRESMA)</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%">No</th>
                <th style="width: 15%">Nama Mahasiswa</th>
                <th style="width: 10%">NIM</th>
                <th style="width: 12%">Program Studi</th>
                <th style="width: 15%">Nama Kegiatan</th>
                <th style="width: 14%">Keterangan</th>
                <th style="width: 12%">Penyelenggara</th>
                <th style="width: 8%">Tingkat</th>
                <th style="width: 5%">Poin</th>
                <th style="width: 5%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td class="text-center">{{ $item->user->nim }}</td>
                <td>{{ $item->user->prodi }}</td>
                <td>{{ $item->kegiatan->kegiatan ?? '-' }}</td>
                <td>{{ $item->keterangan ?? '-' }}</td>
                <td>{{ $item->penyelenggara }}</td>
                <td class="text-center">
                    {{ $item->kegiatan->tingkat ?? '-' }}
                </td>
                <td class="text-center">
                    {{ $item->kegiatan->masterKegiatan->poin ?? 0 }}
                </td>
                <td class="text-center">
                    {{ $item->created_at->format('d/m/Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" class="text-center" style="padding: 20px;">Belum ada data prestasi yang dapat dicetak.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

   

</body>
</html>