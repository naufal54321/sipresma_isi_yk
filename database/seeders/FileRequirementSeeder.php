<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileRequirementSeeder extends Seeder
{
    public function run(): void
    {
        $reqMap = $this->buildRequirementMap();

        $rules = DB::table('point_rules')->get();

        foreach ($rules as $rule) {
            $activityType = DB::table('activity_types')->where('id', $rule->activity_type_id)->first();
            $role = DB::table('activity_roles')->where('id', $rule->role_id)->first();

            if (!$activityType || !$role) continue;

            $key = $activityType->name . '|' . $role->name;
            $files = $reqMap[$key] ?? null;

            if (!$files) continue;

            foreach ($files as $idx => $file) {
                DB::table('file_requirements')->updateOrInsert(
                    ['point_rule_id' => $rule->id, 'file_column' => $file['col']],
                    [
                        'label' => $file['label'],
                        'accept' => $file['accept'],
                        'is_required' => $file['required'],
                        'sort_order' => $idx,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }

    private function pdf(): string { return '.pdf'; }
    private function img(): string { return '.pdf,.jpg,.jpeg,.png'; }

    private function buildRequirementMap(): array
    {
        $pdf = $this->pdf();
        $img = $this->img();

        return [
            // === KOMPETISI SESUAI BIDANG KEILMUAN ===
            'Kompetisi sesuai bidang keilmuan|Peserta' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
            ],
            'Kompetisi sesuai bidang keilmuan|Finalis' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala', 'accept' => $img, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Kompetisi sesuai bidang keilmuan|Juara III' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala', 'accept' => $img, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Kompetisi sesuai bidang keilmuan|Juara II' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala', 'accept' => $img, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Kompetisi sesuai bidang keilmuan|Juara I' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala', 'accept' => $img, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],

            // === PENELITIAN ===
            'Penelitian|Terlibat Penelitian Dosen' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Keputusan Penelitian', 'accept' => $pdf, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],

            // === PKM/PMW ===
            'Program Kreativitas Mahasiswa (PKM)/Program Mahasiswa Wirausaha (PMW)|Proposal' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Proposal', 'accept' => $pdf, 'required' => true],
            ],
            'Program Kreativitas Mahasiswa (PKM)/Program Mahasiswa Wirausaha (PMW)|Proposal Diunggah' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Bukti Proposal Diunggah', 'accept' => $img, 'required' => true],
            ],
            'Program Kreativitas Mahasiswa (PKM)/Program Mahasiswa Wirausaha (PMW)|Pelaksanaan dan Pelaporan' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan Penelitian', 'accept' => $pdf, 'required' => true],
            ],

            // === KEGIATAN ILMIAH ===
            'Kegiatan ilmiah (Seminar, Workshop, dll)|Peserta' => [
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Surat Keterangan', 'accept' => $img, 'required' => true],
            ],
            'Kegiatan ilmiah (Seminar, Workshop, dll)|Moderator' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Undangan', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Surat Keterangan', 'accept' => $img, 'required' => true],
            ],
            'Kegiatan ilmiah (Seminar, Workshop, dll)|Narasumber' => [
                ['col' => 'surat_tugas', 'label' => 'Makalah', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Surat Undangan', 'accept' => $pdf, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],

            // === PUBLIKASI ===
            'Publikasi|Tulisan di koran/majalah' => [
                ['col' => 'sertifikat', 'label' => 'Berkas Tulisan Asli', 'accept' => $img, 'required' => true],
            ],
            'Publikasi|Karya seni dipublikasikan' => [
                ['col' => 'laporan', 'label' => 'Laporan Karya', 'accept' => $pdf, 'required' => true],
            ],
            'Publikasi|Artikel Jurnal Ilmiah Non Terakreditasi' => [
                ['col' => 'surat_tugas', 'label' => 'Surat LoA (Letter of Acceptance)', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Berkas Tulisan Asli', 'accept' => $pdf, 'required' => true],
            ],
            'Publikasi|Artikel Jurnal Ilmiah Terakreditasi' => [
                ['col' => 'surat_tugas', 'label' => 'Surat LoA (Letter of Acceptance)', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Berkas Tulisan Asli', 'accept' => $pdf, 'required' => true],
            ],
            'Publikasi|Buku ISBN (bukan penulis utama)' => [
                ['col' => 'sertifikat', 'label' => 'Buku Asli', 'accept' => $pdf, 'required' => true],
            ],
            'Publikasi|Buku ISBN (penulis utama)' => [
                ['col' => 'sertifikat', 'label' => 'Buku Asli', 'accept' => $pdf, 'required' => true],
            ],
            'Publikasi|Memperoleh HKI' => [
                ['col' => 'sertifikat', 'label' => 'Sertifikat HKI', 'accept' => $img, 'required' => true],
            ],

            // === PENGABDIAN MASYARAKAT SESUAI BIDANG ===
            'Pengabdian Masyarakat sesuai bidang|Rutin (Min. 8 Jam)' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Permintaan / SK Program', 'accept' => $pdf, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Pengabdian Masyarakat sesuai bidang|Insidental' => [
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Surat Tugas', 'accept' => $img, 'required' => true],
            ],

            // === PERTUNJUKAN/KONSER SESUAI BIDANG ===
            'Pertunjukan/Konser sesuai bidang|Tunggal' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Keterangan dari Fakultas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Buku Acara Pertunjukan/Konser', 'accept' => $pdf, 'required' => true],
            ],
            'Pertunjukan/Konser sesuai bidang|Bersama' => [
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Surat Keterangan Penyelenggara', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Buku Acara Pertunjukan/Konser', 'accept' => $pdf, 'required' => true],
            ],

            // === KEROHANIAN ===
            'Kerohanian|Peserta Rutin' => [
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Kerohanian|Peserta Insidental' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Kerohanian|Fasilitator Rutin' => [
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Kerohanian|Fasilitator Insidental' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],

            // === KEPEMIMPINAN ===
            'Kepemimpinan|Peserta Pelatihan' => [
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],
            'Kepemimpinan|Pemateri/Pelatih' => [
                ['col' => 'surat_tugas', 'label' => 'Makalah', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Undangan dari Penyelenggara', 'accept' => $pdf, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],

            // === KETERLIBATAN DALAM ORGANISASI ===
            'Keterlibatan dalam Organisasi|Anggota Bidang' => [
                ['col' => 'surat_tugas', 'label' => 'SK Periode Kepengurusan', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],
            'Keterlibatan dalam Organisasi|Sekretaris/Bendahara/Kabid' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Keputusan', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],
            'Keterlibatan dalam Organisasi|Ketua' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Keputusan', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],

            // === KEPANITIAAN ===
            'Kepanitiaan|Tim Pengarah/Satgas' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],
            'Kepanitiaan|Ketua' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],
            'Kepanitiaan|Sekretaris/Bendahara/Kabid' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],
            'Kepanitiaan|Panitia' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],

            // === BAKAT DAN MINAT ===
            'Bakat dan Minat|Peserta' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Berkas Pendaftaran', 'accept' => $img, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Sertifikat / Surat Keterangan', 'accept' => $img, 'required' => true],
            ],
            'Bakat dan Minat|Finalis' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala', 'accept' => $img, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Bakat dan Minat|Juara III' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala', 'accept' => $img, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Bakat dan Minat|Juara II' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala', 'accept' => $img, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Bakat dan Minat|Juara I' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat / Foto Piala', 'accept' => $img, 'required' => true],
                ['col' => 'foto_penyerahan', 'label' => 'Foto Penyerahan', 'accept' => $img, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],

            // === PENGABDIAN MASYARAKAT LUAR BIDANG ===
            'Pengabdian Masyarakat luar bidang|Rutin (Min. 8 Jam)' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Permintaan / SK Program', 'accept' => $pdf, 'required' => true],
                ['col' => 'laporan', 'label' => 'Laporan (Format Template)', 'accept' => $pdf, 'required' => true],
            ],
            'Pengabdian Masyarakat luar bidang|Insidental' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],

            // === PERTUKARAN MAHASISWA ===
            'Pertukaran Mahasiswa|Peserta' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Keterangan dari Fakultas/Universitas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],

            // === MEMBANTU WEB/DATABASE ===
            'Membantu pembuatan web/database|Tim/Kreator' => [
                ['col' => 'sertifikat', 'label' => 'Surat Keterangan Fakultas/Universitas', 'accept' => $img, 'required' => true],
            ],

            // === KEGIATAN LAINNYA ===
            'Kegiatan lainnya|Peserta/Panitia' => [
                ['col' => 'surat_tugas', 'label' => 'Surat Tugas dari Fakultas/Universitas', 'accept' => $pdf, 'required' => true],
                ['col' => 'sertifikat', 'label' => 'Sertifikat', 'accept' => $img, 'required' => true],
            ],
        ];
    }
}
