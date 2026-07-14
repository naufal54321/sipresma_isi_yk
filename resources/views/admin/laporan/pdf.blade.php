<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Prestasi Mahasiswa - Institut Seni Indonesia Yogyakarta</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 5mm 5mm;
            @bottom-right {
                content: "Halaman " counter(page) " dari " counter(pages);
                font-family: "Times New Roman", Times, serif;
                font-size: 6pt;
                color: #000000;
            }
        }

        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 6pt;
            color: #000000;
            line-height: 1.1;
            margin: 0;
            padding: 0;
        }

        .kop-surat {
            text-align: center;
            margin-bottom: 5px;
            padding-bottom: 4px;
            border-bottom: 2px solid #000000;
        }
        .kop-surat h2 { margin: 0; font-size: 9pt; font-weight: normal; }
        .kop-surat h1 { margin: 0; font-size: 11pt; font-weight: bold; text-transform: uppercase; }
        .kop-surat p { margin: 1px 0 0 0; font-size: 6pt; }

        .judul-dokumen {
            text-align: center;
            margin-bottom: 6px;
        }
        .judul-dokumen h3 { margin: 0; font-size: 8pt; font-weight: bold; text-transform: uppercase; text-decoration: underline; }
        .judul-dokumen p { margin: 1px 0 0 0; font-size: 7pt; }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* ⚡ PENTING: Lebar kolom fixed */
            word-wrap: break-word;
        }
        tr { page-break-inside: avoid; }
        th, td {
            padding: 1px 2px;
            border: 1px solid #000000;
            text-align: left;
            vertical-align: middle;
            font-size: 5.5pt;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        th {
            background-color: #1a5276;
            color: #ffffff;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
            font-size: 5.5pt;
        }

        .text-center { text-align: center; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h2>Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi</h2>
        <h1>Institut Seni Indonesia Yogyakarta</h1>
        <p>Jl. Parangtritis Km. 6,5 Sewon, Bantul, Yogyakarta | Telp: (0274) 379133 | www.isi.ac.id</p>
    </div>

    <div class="judul-dokumen">
        <h3>Laporan Prestasi Mahasiswa</h3>
    </div>

    <table>
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
            @forelse($laporan as $item)
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
                $poin = $item->poin ?? 0;
                
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
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $tanggal }}</td>
                <td class="text-center">{{ $hasil }} ({{ $poin }})</td>
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
                <td colspan="16" class="text-center" style="padding: 20px;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>