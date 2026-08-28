<?php

namespace App\Services;

class FileRequirementService
{
    private static $requirements = [
        'Bidang Orientasi Kompetensi Profesional' => [
            'Kompetisi sesuai dengan bidang keilmuan' => [
                'Peserta' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                ],
                'Finalis' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala'],
                    ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Juara III' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala'],
                    ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Juara II' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala'],
                    ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Juara I' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala'],
                    ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
            ],
            'Penelitian' => [
                'Terlibat Penelitian Dosen' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keputusan Penelitian'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
            ],
            'Program Kreativitas Mahasiswa (PKM)/Program Mahasiswa Wirausaha (PMW) (kegiatan lain sejenis)' => [
                'Proposal' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Proposal'],
                ],
                'Proposal diunggah' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Bukti Proposal Diunggah'],
                ],
                'Pelaksanaan dan Pelaporan' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'laporan', 'label' => 'Laporan Penelitian'],
                ],
            ],
            'Kegiatan ilmiah (Seminar, Workshop, dll)' => [
                'Peserta' => [
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Surat Keterangan'],
                ],
                'Moderator' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Undangan'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Surat Keterangan'],
                ],
                'Narasumber' => [
                    ['col' => 'surat_tugas', 'label' => 'Makalah'],
                    ['col' => 'sertifikat', 'label' => 'Surat Undangan'],
                    ['col' => 'foto_penyerahan', 'label' => 'Sertifikat'],
                ],
            ],
            'Publikasi' => [
                'Tulisan di koran/majalah' => [
                    ['col' => 'sertifikat', 'label' => 'Berkas Tulisan Asli'],
                ],
                'Karya seni dipublikasikan' => [
                    ['col' => 'laporan', 'label' => 'Laporan Karya'],
                ],
                'Artikel Jurnal Ilmiah Non Terakreditasi' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat LoA (Letter of Acceptance)'],
                    ['col' => 'sertifikat', 'label' => 'Berkas Tulisan Asli'],
                ],
                'Artikel Jurnal Ilmiah Terakreditasi' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat LoA (Letter of Acceptance)'],
                    ['col' => 'sertifikat', 'label' => 'Berkas Tulisan Asli'],
                ],
                'Buku ISBN (bukan penulis utama)' => [
                    ['col' => 'sertifikat', 'label' => 'Buku Asli'],
                ],
                'Buku ISBN (penulis utama)' => [
                    ['col' => 'sertifikat', 'label' => 'Buku Asli'],
                ],
                'Memperoleh HKI' => [
                    ['col' => 'sertifikat', 'label' => 'Sertifikat HKI'],
                ],
            ],
            'Pengabdian Masyarakat sesuai bidang' => [
                'Rutin (Min. 8 Jam)' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Permintaan / SK Program'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Insidental' => [
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Surat Tugas'],
                ],
            ],
            'Pertunjukan/Konser sesuai bidang' => [
                'Tunggal' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keterangan dari Fakultas'],
                    ['col' => 'sertifikat', 'label' => 'Buku Acara Pertunjukan/Konser'],
                ],
                'Bersama' => [
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Surat Keterangan Penyelenggara'],
                    ['col' => 'laporan', 'label' => 'Buku Acara Pertunjukan/Konser'],
                ],
            ],
        ],
        'Bidang Kompetensi Kepribadian dan Sosial' => [
            'Kerohanian' => [
                'Peserta (Rutin)' => [
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Peserta (Insidental)' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Fasilitator/Mentor (Rutin)' => [
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Fasilitator/Mentor (Insidental)' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
            ],
            'Fasilitator/Mentor/Narasumber' => [
                'Rutin' => [
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                    ['col' => 'foto_penyerahan', 'label' => 'Daftar Hadir (Min. 8 Tatap Muka)'],
                ],
                'Insidental' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
            ],
            'Kepemimpinan' => [
                'Peserta Pelatihan' => [
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
                'Pemateri/Pelatih' => [
                    ['col' => 'surat_tugas', 'label' => 'Makalah'],
                    ['col' => 'sertifikat', 'label' => 'Undangan dari Penyelenggara'],
                    ['col' => 'foto_penyerahan', 'label' => 'Sertifikat'],
                ],
            ],
            'Organisasi - Lembaga Kemahasiswaan' => [
                'Anggota bidang' => [
                    ['col' => 'surat_tugas', 'label' => 'SK Periode Kepengurusan'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
                'Sekretaris/Bendahara/Kabid' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keputusan'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
                'Ketua' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keputusan'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
            ],
            'Organisasi - Kelompok Minat Bakat' => [
                'Anggota' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keputusan'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
                'Sekretaris/Bendahara/Kabid' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keputusan'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
                'Ketua' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keputusan'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
            ],
            'Organisasi - Kepanitiaan' => [
                'Tim Pengarah/Satgas' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
                'Sekretaris/Bendahara/Kabid' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
                'Ketua Panitia' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
            ],
            'Bakat dan Minat - Kompetisi' => [
                'Peserta' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Berkas Pendaftaran'],
                    ['col' => 'foto_penyerahan', 'label' => 'Sertifikat / Surat Keterangan'],
                ],
                'Finalis' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala'],
                    ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Juara III' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala'],
                    ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Juara II' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala'],
                    ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Juara I' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala'],
                    ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
            ],
            'Bakat dan Minat - Konser/Pameran Luar Bidang' => [
                'Tunggal' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keterangan dari Fakultas'],
                    ['col' => 'sertifikat', 'label' => 'Buku Acara Konser/Pameran'],
                ],
                'Bersama' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keterangan dari Fakultas'],
                    ['col' => 'sertifikat', 'label' => 'Buku Acara Konser/Pameran'],
                ],
            ],
            'Pengabdian Masyarakat luar bidang' => [
                'Rutin (Min. 8 Jam)' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Permintaan / SK Program'],
                    ['col' => 'laporan', 'label' => 'Laporan (Format Template)'],
                ],
                'Insidental' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
            ],
            'Peserta pertukaran mahasiswa' => [
                'Peserta' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Keterangan dari Fakultas/Universitas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
            ],
            'Membantu pembuatan web/database' => [
                'Tim/Kreator' => [
                    ['col' => 'sertifikat', 'label' => 'Surat Keterangan Fakultas/Universitas'],
                ],
            ],
            'Kegiatan di luar kompetensi profesional & sosial' => [
                'Peserta/Panitia' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
            ],
            'Kegiatan pengelolaan kampus' => [
                'Asisten Dosen' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
                'Kehumasan' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
                'Tim Akreditasi' => [
                    ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas'],
                    ['col' => 'sertifikat', 'label' => 'Sertifikat'],
                ],
            ],
        ],
    ];

    private static $accepts = [
        'surat_tugas' => '.pdf',
        'sertifikat' => '.pdf,.jpg,.jpeg,.png',
        'foto_penyerahan' => '.pdf,.jpg,.jpeg,.png',
        'laporan' => '.pdf',
    ];

    public static function getRequiredFileCols($bidang, $jenis, $peran): array
    {
        $entries = self::$requirements[$bidang][$jenis][$peran] ?? [];
        return array_map(fn($e) => $e['col'], $entries);
    }

    public static function getRequiredFiles($bidang, $jenis, $peran): array
    {
        $entries = self::$requirements[$bidang][$jenis][$peran] ?? [];
        return array_map(fn($e) => [
            'col' => $e['col'],
            'label' => $e['label'] ?? ucfirst(str_replace('_', ' ', $e['col'])),
            'accept' => self::$accepts[$e['col']] ?? '*',
        ], $entries);
    }

    public static function getFileLabel($col): string
    {
        return ucfirst(str_replace('_', ' ', $col));
    }

    public static function getFileAccept($col): string
    {
        return self::$accepts[$col] ?? '*';
    }
}
