<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spks', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada, jika belum baru tambah
            if (!Schema::hasColumn('spks', 'link_drive')) {
                $table->string('link_drive')->nullable()->after('url_kegiatan');
            }
            if (!Schema::hasColumn('spks', 'surat_tugas')) {
                $table->string('surat_tugas')->nullable()->after('link_drive');
            }
            if (!Schema::hasColumn('spks', 'sertifikat')) {
                $table->string('sertifikat')->nullable()->after('surat_tugas');
            }
            if (!Schema::hasColumn('spks', 'foto_penyerahan')) {
                $table->string('foto_penyerahan')->nullable()->after('sertifikat');
            }
            if (!Schema::hasColumn('spks', 'laporan')) {
                $table->string('laporan')->nullable()->after('foto_penyerahan');
            }
        });
    }

    public function down(): void
    {
        Schema::table('spks', function (Blueprint $table) {
            $table->dropColumn(['link_drive', 'surat_tugas', 'sertifikat', 'foto_penyerahan', 'laporan']);
        });
    }
};