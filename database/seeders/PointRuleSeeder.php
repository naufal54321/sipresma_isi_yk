<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PointRuleSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedCompetencyFields();
        $this->seedActivityTypes();
        $this->seedActivityScopes();
        $this->seedActivityRoles();
        $this->seedAchievementTypes();
        $this->seedPointRules();
    }

    private function seedCompetencyFields(): void
    {
        $fields = [
            ['name' => 'Kompetensi Profesional', 'description' => 'Bidang kompetensi profesional mahasiswa', 'is_active' => true],
            ['name' => 'Kompetensi Kepribadian dan Sosial', 'description' => 'Bidang kepribadian dan sosial mahasiswa', 'is_active' => true],
        ];
        foreach ($fields as $f) {
            DB::table('competency_fields')->updateOrInsert(['name' => $f['name']], array_merge($f, ['created_at' => now(), 'updated_at' => now()]));
        }
    }

    private function seedActivityTypes(): void
    {
        $profId = DB::table('competency_fields')->where('name', 'Kompetensi Profesional')->first()->id;
        $sosId = DB::table('competency_fields')->where('name', 'Kompetensi Kepribadian dan Sosial')->first()->id;

        $types = [
            // Profesional
            ['competency_field_id' => $profId, 'name' => 'Kompetisi sesuai bidang keilmuan', 'evidence_required' => 'Sertifikat, Foto Piala, Surat Keterangan'],
            ['competency_field_id' => $profId, 'name' => 'Penelitian', 'evidence_required' => 'Surat Keputusan penelitian oleh Fakultas/Universitas/Institusi Pemerintah'],
            ['competency_field_id' => $profId, 'name' => 'Program Kreativitas Mahasiswa (PKM)/Program Mahasiswa Wirausaha (PMW)', 'evidence_required' => 'Proposal, Bukti Unggah, Laporan Pelaksanaan'],
            ['competency_field_id' => $profId, 'name' => 'Kegiatan ilmiah (Seminar, Workshop, dll)', 'evidence_required' => 'Sertifikat, Undangan, Makalah'],
            ['competency_field_id' => $profId, 'name' => 'Publikasi', 'evidence_required' => 'Bukti publikasi (koran/jurnal/buku/HKI)'],
            ['competency_field_id' => $profId, 'name' => 'Pengabdian Masyarakat sesuai bidang', 'evidence_required' => 'Surat Keterangan, Laporan, Foto Kegiatan'],
            ['competency_field_id' => $profId, 'name' => 'Pertunjukan/Konser sesuai bidang', 'evidence_required' => 'Sertifikat, Undangan, Foto/Dokumentasi'],
            // Kepribadian & Sosial
            ['competency_field_id' => $sosId, 'name' => 'Kerohanian', 'evidence_required' => 'Sertifikat, Surat Keterangan, Foto Kegiatan'],
            ['competency_field_id' => $sosId, 'name' => 'Kepemimpinan', 'evidence_required' => 'Sertifikat Pelatihan, Surat Keterangan'],
            ['competency_field_id' => $sosId, 'name' => 'Keterlibatan dalam Organisasi', 'evidence_required' => 'SK Pengurus, Surat Keterangan Organisasi'],
            ['competency_field_id' => $sosId, 'name' => 'Kepanitiaan', 'evidence_required' => 'SK Panitia, Surat Keterangan, Foto Kegiatan'],
            ['competency_field_id' => $sosId, 'name' => 'Bakat dan Minat', 'evidence_required' => 'Sertifikat, Foto/Dokumentasi'],
            ['competency_field_id' => $sosId, 'name' => 'Pengabdian Masyarakat luar bidang', 'evidence_required' => 'Surat Keterangan, Laporan, Foto Kegiatan'],
            ['competency_field_id' => $sosId, 'name' => 'Pertukaran Mahasiswa', 'evidence_required' => 'Surat Tugas, Sertifikat, Transkrip Nilai'],
            ['competency_field_id' => $sosId, 'name' => 'Membantu pembuatan web/database', 'evidence_required' => 'Surat Keterangan, Bukti Web/Database'],
            ['competency_field_id' => $sosId, 'name' => 'Kegiatan lainnya', 'evidence_required' => 'Surat Keterangan, Foto Kegiatan'],
        ];
        foreach ($types as $t) {
            DB::table('activity_types')->updateOrInsert(
                ['competency_field_id' => $t['competency_field_id'], 'name' => $t['name']],
                array_merge($t, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()])
            );
        }
    }

    private function seedActivityScopes(): void
    {
        $scopes = [
            ['code' => '-', 'name' => 'Tidak Ada / Statis'],
            ['code' => 'PS', 'name' => 'Program Studi'],
            ['code' => 'F', 'name' => 'Fakultas'],
            ['code' => 'K', 'name' => 'Institut/Kampus'],
            ['code' => 'L', 'name' => 'Lokal (DIY & Sekitar)'],
            ['code' => 'N', 'name' => 'Nasional'],
            ['code' => 'IN', 'name' => 'Internasional'],
        ];
        foreach ($scopes as $s) {
            DB::table('activity_scopes')->updateOrInsert(['code' => $s['code']], array_merge($s, ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]));
        }
    }

    private function seedActivityRoles(): void
    {
        $roles = [
            'Peserta', 'Finalis', 'Juara I', 'Juara II', 'Juara III',
            'Moderator', 'Narasumber', 'Fasilitator', 'Mentor',
            'Ketua', 'Sekretaris', 'Bendahara', 'Anggota',
            'Ketua Bidang', 'Tim Pengarah', 'Satgas', 'Panitia',
            'Terlibat Penelitian Dosen', 'Proposal', 'Proposal Diunggah',
            'Pelaksanaan dan Pelaporan', 'Rutin (Min. 8 Jam)', 'Insidental',
            'Peserta Rutin', 'Peserta Insidental', 'Fasilitator Rutin', 'Fasilitator Insidental',
            'Peserta Pelatihan', 'Pemateri/Pelatih', 'Anggota Bidang',
            'Sekretaris/Bendahara/Kabid', 'Tim Pengarah/Satgas',
            'Tunggal', 'Bersama', 'Tim/Kreator', 'Peserta/Panitia',
            'Asisten Dosen', 'Kehumasan', 'Tim Akreditasi',
        ];
        foreach ($roles as $name) {
            DB::table('activity_roles')->updateOrInsert(['name' => $name], ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    private function seedAchievementTypes(): void
    {
        $types = ['Peserta', 'Finalis', 'Juara III', 'Juara II', 'Juara I'];
        foreach ($types as $name) {
            DB::table('achievement_types')->updateOrInsert(['name' => $name], ['is_active' => true, 'created_at' => now(), 'updated_at' => now()]);
        }
    }

    private function seedPointRules(): void
    {
        $cf = fn($name) => DB::table('competency_fields')->where('name', $name)->first()->id;
        $at = fn($cfId, $name) => DB::table('activity_types')->where('competency_field_id', $cfId)->where('name', $name)->first()->id;
        $sc = fn($name) => DB::table('activity_scopes')->where('name', $name)->first()->id ?? null;
        $rl = fn($name) => DB::table('activity_roles')->where('name', $name)->first()->id ?? null;

        $profId = $cf('Kompetensi Profesional');
        $sosId = $cf('Kompetensi Kepribadian dan Sosial');

        $rules = [];

        // === KOMPETISI BIDANG KEILMUAN ===
        $kompetisiId = $at($profId, 'Kompetisi sesuai bidang keilmuan');
        $roles = ['Peserta', 'Finalis', 'Juara III', 'Juara II', 'Juara I'];
        $peserta = [5, 10, 15, null];
        $finalis = [10, 15, 20, 25];
        $jIII = [15, 20, 25, 30];
        $jII = [20, 25, 30, 35];
        $jI = [25, 30, 35, 40];
        $scopes = ['Kampus', 'Lokal (DIY & Sekitar)', 'Nasional', 'Internasional'];
        $allPoints = [$peserta, $finalis, $jIII, $jII, $jI];

        foreach ($allPoints as $ri => $rolePoints) {
            foreach ($rolePoints as $si => $poin) {
                if ($poin === null) continue;
                $rules[] = [
                    'competency_field_id' => $profId, 'activity_type_id' => $kompetisiId,
                    'scope_id' => $sc($scopes[$si]), 'role_id' => $rl($roles[$ri]),
                    'achievement_id' => null, 'points' => $poin, 'max_usage' => 4, 'is_active' => true,
                ];
            }
        }

        // === PENELITIAN ===
        $penelitianId = $at($profId, 'Penelitian');
        $penelitianPoin = [15, 20, 25, 35];
        foreach ($penelitianPoin as $si => $poin) {
            $rules[] = [
                'competency_field_id' => $profId, 'activity_type_id' => $penelitianId,
                'scope_id' => $sc($scopes[$si]), 'role_id' => $rl('Terlibat Penelitian Dosen'),
                'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
            ];
        }

        // === KEGIATAN ILMIAH ===
        $ilmiahId = $at($profId, 'Kegiatan ilmiah (Seminar, Workshop, dll)');
        $ilmiahPeserta = [5, 7, 10, 12];
        $ilmiahMod = [10, 15, 17, 20];
        $ilmiahNar = [20, 25, 30, 50];
        $ilmiahRoles = ['Peserta', 'Moderator', 'Narasumber'];
        $ilmiahData = [$ilmiahPeserta, $ilmiahMod, $ilmiahNar];
        foreach ($ilmiahData as $ri => $poinArr) {
            foreach ($poinArr as $si => $poin) {
                $rules[] = [
                    'competency_field_id' => $profId, 'activity_type_id' => $ilmiahId,
                    'scope_id' => $sc($scopes[$si]), 'role_id' => $rl($ilmiahRoles[$ri]),
                    'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
                ];
            }
        }

        // === PUBLIKASI ===
        $publikasiId = $at($profId, 'Publikasi');
        $pubRoles = ['Tulisan di koran/majalah', 'Karya seni dipublikasikan'];
        $pubPoin = [[10, 20, 30, 50], [10, 15, 25, 35]];
        foreach ($pubPoin as $ri => $poinArr) {
            foreach ($poinArr as $si => $poin) {
                $rules[] = [
                    'competency_field_id' => $profId, 'activity_type_id' => $publikasiId,
                    'scope_id' => $sc($scopes[$si]), 'role_id' => $rl($pubRoles[$ri]),
                    'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
                ];
            }
        }
        // Jurnal
        $jurnalRoles = ['Artikel Jurnal Ilmiah Non Terakreditasi', 'Artikel Jurnal Ilmiah Terakreditasi'];
        $jurnalPoin = [20, 50];
        foreach ($jurnalPoin as $ri => $poin) {
            $rules[] = [
                'competency_field_id' => $profId, 'activity_type_id' => $publikasiId,
                'scope_id' => $sc('Nasional'), 'role_id' => $rl($jurnalRoles[$ri]),
                'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
            ];
            $rules[] = [
                'competency_field_id' => $profId, 'activity_type_id' => $publikasiId,
                'scope_id' => $sc('Internasional'), 'role_id' => $rl($jurnalRoles[$ri]),
                'achievement_id' => null, 'points' => $poin + 20, 'max_usage' => null, 'is_active' => true,
            ];
        }
        // Buku ISBN
        $bukuRoles = ['Buku ISBN (bukan penulis utama)', 'Buku ISBN (penulis utama)'];
        $bukuPoin = [30, 50];
        foreach ($bukuPoin as $ri => $poin) {
            $rules[] = [
                'competency_field_id' => $profId, 'activity_type_id' => $publikasiId,
                'scope_id' => $sc('Nasional'), 'role_id' => $rl($bukuRoles[$ri]),
                'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
            ];
        }
        // HKI
        $rules[] = [
            'competency_field_id' => $profId, 'activity_type_id' => $publikasiId,
            'scope_id' => $sc('Nasional'), 'role_id' => $rl('Memperoleh HKI'),
            'achievement_id' => null, 'points' => 15, 'max_usage' => null, 'is_active' => true,
        ];

        // === PENGABDIAN MASYARAKAT SESUAI BIDANG ===
        $pmId = $at($profId, 'Pengabdian Masyarakat sesuai bidang');
        $rules[] = [
            'competency_field_id' => $profId, 'activity_type_id' => $pmId,
            'scope_id' => $sc('Kampus'), 'role_id' => $rl('Rutin (Min. 8 Jam)'),
            'achievement_id' => null, 'points' => 15, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $profId, 'activity_type_id' => $pmId,
            'scope_id' => $sc('Kampus'), 'role_id' => $rl('Insidental'),
            'achievement_id' => null, 'points' => 10, 'max_usage' => null, 'is_active' => true,
        ];

        // === PERTUNJUKAN/KONSER SESUAI BIDANG ===
        $pertId = $at($profId, 'Pertunjukan/Konser sesuai bidang');
        $pertRoles = ['Tunggal', 'Bersama'];
        $pertPoin = [
            [10, 20, 25, null],
            [5, 15, 20, null],
        ];
        foreach ($pertPoin as $ri => $poinArr) {
            foreach ($poinArr as $si => $poin) {
                if ($poin === null) continue;
                $rules[] = [
                    'competency_field_id' => $profId, 'activity_type_id' => $pertId,
                    'scope_id' => $sc($scopes[$si]), 'role_id' => $rl($pertRoles[$ri]),
                    'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
                ];
            }
        }

        // === KEROHANIAN ===
        $rohId = $at($sosId, 'Kerohanian');
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $rohId,
            'scope_id' => $sc('Kampus'), 'role_id' => $rl('Peserta Rutin'),
            'achievement_id' => null, 'points' => 7, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $rohId,
            'scope_id' => $sc('Kampus'), 'role_id' => $rl('Peserta Insidental'),
            'achievement_id' => null, 'points' => 3, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $rohId,
            'scope_id' => $sc('Kampus'), 'role_id' => $rl('Fasilitator Rutin'),
            'achievement_id' => null, 'points' => 12, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $rohId,
            'scope_id' => $sc('Kampus'), 'role_id' => $rl('Fasilitator Insidental'),
            'achievement_id' => null, 'points' => 7, 'max_usage' => null, 'is_active' => true,
        ];

        // === KEPEMIMPINAN ===
        $kepId = $at($sosId, 'Kepemimpinan');
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $kepId,
            'scope_id' => $sc('Program Studi'), 'role_id' => $rl('Peserta Pelatihan'),
            'achievement_id' => null, 'points' => 5, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $kepId,
            'scope_id' => $sc('Fakultas'), 'role_id' => $rl('Peserta Pelatihan'),
            'achievement_id' => null, 'points' => 15, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $kepId,
            'scope_id' => $sc('Institut/Kampus'), 'role_id' => $rl('Peserta Pelatihan'),
            'achievement_id' => null, 'points' => 20, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $kepId,
            'scope_id' => $sc('Program Studi'), 'role_id' => $rl('Pemateri/Pelatih'),
            'achievement_id' => null, 'points' => 10, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $kepId,
            'scope_id' => $sc('Fakultas'), 'role_id' => $rl('Pemateri/Pelatih'),
            'achievement_id' => null, 'points' => 25, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $kepId,
            'scope_id' => $sc('Institut/Kampus'), 'role_id' => $rl('Pemateri/Pelatih'),
            'achievement_id' => null, 'points' => 30, 'max_usage' => null, 'is_active' => true,
        ];

        // === ORGANISASI - LEMBAGA KEMAHASISWAAN ===
        $orgId = $at($sosId, 'Keterlibatan dalam Organisasi');
        $orgRoles = ['Anggota Bidang', 'Sekretaris/Bendahara/Kabid', 'Ketua'];
        $orgPoin = [
            [10, 15, 20],
            [25, 30, 35],
            [50, 60, 70],
        ];
        foreach ($orgPoin as $ri => $poinArr) {
            foreach ($poinArr as $si => $poin) {
                $rules[] = [
                    'competency_field_id' => $sosId, 'activity_type_id' => $orgId,
                    'scope_id' => $sc($scopes[$si]), 'role_id' => $rl($orgRoles[$ri]),
                    'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
                ];
            }
        }

        // === KEPANITIAAN ===
        $panId = $at($sosId, 'Kepanitiaan');
        $panRoles = ['Tim Pengarah/Satgas', 'Ketua', 'Sekretaris/Bendahara/Kabid', 'Panitia'];
        $panPoin = [
            [5, 7, 10, 12],
            [10, 15, 20, 30],
            [7, 10, 15, 20],
            [5, 7, 10, 12],
        ];
        foreach ($panPoin as $ri => $poinArr) {
            foreach ($poinArr as $si => $poin) {
                $rules[] = [
                    'competency_field_id' => $sosId, 'activity_type_id' => $panId,
                    'scope_id' => $sc($scopes[$si]), 'role_id' => $rl($panRoles[$ri]),
                    'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
                ];
            }
        }

        // === BAKAT DAN MINAT - KOMPETISI ===
        $bakatId = $at($sosId, 'Bakat dan Minat');
        $bakatRoles = ['Peserta', 'Finalis', 'Juara III', 'Juara II', 'Juara I'];
        $bakatPoin = [
            [3, 7, 10, null],
            [5, 10, 15, null],
            [10, 15, 20, 25],
            [15, 20, 25, 30],
            [20, 25, 30, 35],
        ];
        foreach ($bakatPoin as $ri => $poinArr) {
            foreach ($poinArr as $si => $poin) {
                if ($poin === null) continue;
                $rules[] = [
                    'competency_field_id' => $sosId, 'activity_type_id' => $bakatId,
                    'scope_id' => $sc($scopes[$si]), 'role_id' => $rl($bakatRoles[$ri]),
                    'achievement_id' => null, 'points' => $poin, 'max_usage' => 4, 'is_active' => true,
                ];
            }
        }

        // === PENGABDIAN MASYARAKAT LUAR BIDANG ===
        $pmlId = $at($sosId, 'Pengabdian Masyarakat luar bidang');
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $pmlId,
            'scope_id' => $sc('Kampus'), 'role_id' => $rl('Rutin (Min. 8 Jam)'),
            'achievement_id' => null, 'points' => 10, 'max_usage' => null, 'is_active' => true,
        ];
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $pmlId,
            'scope_id' => $sc('Kampus'), 'role_id' => $rl('Insidental'),
            'achievement_id' => null, 'points' => 5, 'max_usage' => null, 'is_active' => true,
        ];

        // === PERTUKARAN MAHASISWA ===
        $ptmId = $at($sosId, 'Pertukaran Mahasiswa');
        $ptmPoin = [20, 30, 40];
        $ptmScopes = ['Kampus', 'Nasional', 'Internasional'];
        foreach ($ptmPoin as $si => $poin) {
            $rules[] = [
                'competency_field_id' => $sosId, 'activity_type_id' => $ptmId,
                'scope_id' => $sc($ptmScopes[$si]), 'role_id' => $rl('Peserta'),
                'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
            ];
        }

        // === MEMBANTU WEB/DATABASE ===
        $webId = $at($sosId, 'Membantu pembuatan web/database');
        $webPoin = [7, 10, 12, 15];
        foreach ($webPoin as $si => $poin) {
            $rules[] = [
                'competency_field_id' => $sosId, 'activity_type_id' => $webId,
                'scope_id' => $sc($scopes[$si]), 'role_id' => $rl('Tim/Kreator'),
                'achievement_id' => null, 'points' => $poin, 'max_usage' => null, 'is_active' => true,
            ];
        }

        // === KEGIATAN LAINNYA ===
        $lainId = $at($sosId, 'Kegiatan lainnya');
        $rules[] = [
            'competency_field_id' => $sosId, 'activity_type_id' => $lainId,
            'scope_id' => $sc('Kampus'), 'role_id' => $rl('Peserta/Panitia'),
            'achievement_id' => null, 'points' => 5, 'max_usage' => null, 'is_active' => true,
        ];

        // Insert all rules
        foreach ($rules as $rule) {
            $exists = DB::table('point_rules')
                ->where('competency_field_id', $rule['competency_field_id'])
                ->where('activity_type_id', $rule['activity_type_id'])
                ->where('scope_id', $rule['scope_id'])
                ->where('role_id', $rule['role_id'])
                ->where('achievement_id', $rule['achievement_id'])
                ->exists();

            if (!$exists) {
                DB::table('point_rules')->insert(array_merge($rule, ['created_at' => now(), 'updated_at' => now()]));
            }
        }
    }
}
