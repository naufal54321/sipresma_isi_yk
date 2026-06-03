<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('kegiatans', function (Blueprint $table) {

        $table->id();

        $table->foreignId('rpk_id')
            ->constrained()
            ->onDelete('cascade');

        $table->string('kegiatan');
        $table->string('jenis');
        $table->string('tingkat');
        $table->string('hasil');

        $table->date('tanggal');

        $table->enum('peran', [
            'Ketua',
            'Anggota'
        ]);

        $table->integer('jumlah_anggota')
            ->nullable();

        $table->enum('status', [
            'draft',
            'disetujui',
            'ditolak'
        ])->default('draft');

        $table->text('catatan_dosen')
            ->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
