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
       Schema::create('master_kegiatans', function (Blueprint $table) {

    $table->id();

    $table->string('nama_kegiatan');

    $table->string('jenis');

    $table->string('tingkat');

    $table->string('hasil');

    $table->integer('poin');

    $table->enum('status', [
        'aktif',
        'tidak aktif'
    ])->default('aktif');

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kegiatans');
    }
};
