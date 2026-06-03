<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spks', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('rpk_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('kegiatan_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->year('tahun');

            $table->date('tanggal_kegiatan');

            $table->string('penyelenggara');

            $table->enum('kategori', [
                'Individu',
                'Kelompok'
            ]);

            $table->string('url_kegiatan')->nullable();

            $table->string('bukti');

            $table->text('keterangan');

            $table->enum('status', [
                'draft',
                'disetujui',
                'ditolak'
            ])->default('draft');

            $table->text('catatan_dosen')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spks');
    }
};