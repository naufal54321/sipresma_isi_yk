<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Prestasi Mahasiswa Bimbingan</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 5mm 5mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 5.5pt;
            color: #000;
            line-height: 1.1;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #1a5276;
            padding-bottom: 5px;
            margin-bottom: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 10pt;
            text-transform: uppercase;
            color: #1a5276;
        }
        .header p {
            margin: 2px 0 0 0;
            font-size: 7pt;
            color: #555;
        }

        .info-dosen {
            margin-bottom: 8px;
        }
        .info-dosen table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-dosen td {
            padding: 1px 3px;
            font-size: 7pt;
            vertical-align: top;
        }

        .table-data {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            word-wrap: break-word;
            margin-bottom: 15px;
        }
        .table-data th, .table-data td {
            border: 1px solid #000;
            padding: 1px 2px;
            text-align: left;
            font-size: 5.5pt;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        .table-data th {
            background-color: #1a5276;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            font-size: 5.5pt;
        }
        .text-center { text-align: center; }

        .footer {
            width: 100%;
            margin-top: 20px;
            font-size: 8pt;
        }
        .ttd-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .ttd-space { height: 60px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Rekapitulasi Prestasi Mahasiswa Bimbingan</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB</p>
    </div>

    <div class="info-dosen">
        <table>
            <tr>
                <td width="12%"><strong>Dosen</strong></td>
                <td width="2%">:</td>
                <td width="30%">{{ $dosen->name ?? '-' }}</td>
                <td width="12%"><strong>NIP/NIDN</strong></td>
                <td width="2%">:</td>
                <td width="30%">{{ $dosen->nim ?? '-' }}</td>
                <td width="5%"><strong>Total</strong></td>
                <td width="2%">:</td>
                <td width="5%">{{ count($laporan) }} Data</td>
            </tr>
        </table>
    </div>

    <table class="table-data">
        <thead>
            <tr>
                <th style="width: 2%">No</th>
                <th style="width: 7%">Waktu Perolehan Prestasi</th>
                <th style="width: 7%">Capaian/Peringkat/Penghargaan</th>
                <th style="width: 5%">Kategori</th>
                <th style="width: 7%">Nama</th>
                <th style="width: 6%">Prodi</th>
                <th style="width: 5%">Angkatan/Smt</th>
                <th style="width: 8%">Email</th>
                <th style="width: 7%">Dosen Pembimbing</th>
                <th style="width: 8%">Judul Karya/Inovasi/Riset/Prestasi</th>
                <th style="width: 8%">Biografi/Latar Belakang</th>
                <th style="width: 8%">Rincian Inovasi/Riset/Prestasi</th>
                <th style="width: 7%">Kebaruan/Keunggulan</th>
                <th style="width: 6%">Nama Ajang/Kegiatan</th>
                <th style="width: 6%">Penyelenggara</th>
                <th style="width: 5%">Tingkat</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
                @php
                    $user = $item->user;
                    $nama = ($user->name ?? '-') . ' (' . ($user->nim ?? '-') . ')';
                    $prodi = $user->prodi ?? '-';
                    $email = $user->email ?? '-';
                    
                    $angkatan = $user->angkatan ?? '';
                    $semester = $user->semester ?? '';
                    $angkatanSemester = trim($angkatan . ($semester ? '/' . $semester : ''));
                    if (empty($angkatanSemester)) $angkatanSemester = '-';
                    
                    $dosenPembimbing = $user->dosenPembimbing->name ?? '-';
                    
                    $judulKegiatan = $item->judul_kegiatan ?? $item->kegiatan->judul_kegiatan ?? $item->kegiatan->kegiatan ?? '-';
                    $namaKegiatan = $item->kegiatan->kegiatan ?? '-';
                    $penyelenggara = $item->penyelenggara ?? '-';
                    $tingkat = $item->tingkat ?? '-';
                    $hasil = $item->hasil ?? '-';
                    
                    if ($item->kegiatan && $item->kegiatan->tanggal_selesai) {
                        $tanggal = \Carbon\Carbon::parse($item->kegiatan->tanggal_selesai)->format('d/m/Y');
                    } elseif ($item->kegiatan && $item->kegiatan->tanggal_mulai) {
                        $tanggal = \Carbon\Carbon::parse($item->kegiatan->tanggal_mulai)->format('d/m/Y');
                    } else {
                        $tanggal = '-';
                    }
                    
                    $kategori = $item->kegiatan->kategori ?? $item->kegiatan->masterKegiatan->kategori ?? 'Prestasi';
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $tanggal }}</td>
                    <td class="text-center">{{ $hasil }}</td>
                    <td>{{ $kategori }}</td>
                    <td>{{ $nama }}</td>
                    <td>{{ $prodi }}</td>
                    <td class="text-center">{{ $angkatanSemester }}</td>
                    <td>{{ $email }}</td>
                    <td>{{ $dosenPembimbing }}</td>
                    <td>{{ $item->judul_karya ?? '-' }}</td>
                    <td>{{ $item->biografi ?? '-' }}</td>
                    <td>{{ $item->rincian ?? '-' }}</td>
                    <td>{{ $item->kebaruan ?? '-' }}</td>
                    <td>{{ $judulKegiatan }}</td>
                    <td>{{ $penyelenggara }}</td>
                    <td class="text-center">{{ $tingkat }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="16" class="text-center" style="padding: 15px;">Tidak ada data prestasi pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <div class="ttd-box">
            <p>Yogyakarta, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>Dosen Pembimbing,</p>
            <div class="ttd-space"></div>
            <p><strong>{{ $dosen->name ?? '_______________________' }}</strong></p>
        </div>
        <div style="clear: both;"></div>
    </div>

</body>
</html>