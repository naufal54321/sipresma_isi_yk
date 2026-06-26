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
    Schema::create('master_prestasis', function (Blueprint $table) {
        $table->id();
        $table->string('juara'); // Contoh: Juara 1, Harapan 2, Peserta
        $table->integer('poin'); // Contoh: 10, 5, 2
        $table->boolean('is_active')->default(true); // Status: Aktif (1) / Tidak (0)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_prestasis');
    }
};
