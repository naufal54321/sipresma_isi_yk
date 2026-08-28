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
        Schema::create('kkm_rules', function (Blueprint $table) {
            $table->id();
            $table->enum('bidang', ['Kompetensi Profesional', 'Kompetensi Kepribadian dan Sosial']);
            $table->string('jenis_kegiatan');
            $table->string('ruang_lingkup')->nullable();
            $table->string('peran');
            $table->string('hasil')->nullable();
            $table->integer('poin');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kkm_rules');
    }
};
