<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Prestasi Mahasiswa Bimbingan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #555;
        }
        .info-dosen {
            margin-bottom: 20px;
        }
        .info-dosen table {
            width: 60%;
            border-collapse: collapse;
        }
        .info-dosen td {
            padding: 3px 0;
            vertical-align: top;
        }
        .table-data {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table-data th, .table-data td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        .table-data th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            width: 100%;
            margin-top: 40px;
        }
        .ttd-box {
            float: right;
            width: 250px;
            text-align: center;
        }
        .ttd-space {
            height: 80px;
        }
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
                <td width="35%"><strong>Dosen Pembimbing</strong></td>
                <td width="5%">:</td>
                <td width="60%">{{ $dosen->name ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>NIP/NIDN</strong></td>
                <td>:</td>
                <td>{{ $dosen->nidn ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Total Data</strong></td>
                <td>:</td>
                <td>{{ count($laporan) }} Kegiatan</td>
            </tr>
        </table>
    </div>

    <table class="table-data">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="15%">Nama Mahasiswa</th>
                <th width="10%">NIM</th>
                <th width="18%">Judul Kegiatan</th>
                <th width="15%">Nama Kegiatan</th>
                <th width="10%">Tingkat</th>
                <th width="10%">Hasil</th>
                <th width="8%">Tahun</th>
                <th width="5%">Poin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td class="text-center">{{ $item->user->nim ?? '-' }}</td>
                    {{-- 🔧 JUDUL KEGIATAN --}}
                    <td>{{ $item->judul_kegiatan ?? $item->kegiatan->judul_kegiatan ?? $item->kegiatan->kegiatan ?? '-' }}</td>
                    <td>{{ $item->kegiatan->kegiatan ?? '-' }}</td>
                    {{-- 🔧 TINGKAT DARI SPK --}}
                    <td class="text-center">{{ $item->tingkat ?? '-' }}</td>
                    {{-- 🔧 HASIL DARI SPK --}}
                    <td class="text-center">{{ $item->hasil ?? '-' }}</td>
                    <td class="text-center">{{ $item->tahun ?? '-' }}</td>
                    {{-- 🔧 POIN DARI SPK --}}
                    <td class="text-center"><strong>{{ $item->poin ?? 0 }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data prestasi pada periode ini.</td>
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