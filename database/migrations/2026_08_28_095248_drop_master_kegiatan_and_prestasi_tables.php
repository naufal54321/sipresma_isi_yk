<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('master_kegiatans');
        Schema::dropIfExists('master_prestasis');
    }

    public function down(): void
    {
        Schema::create('master_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps();
        });

        Schema::create('master_prestasis', function (Blueprint $table) {
            $table->id();
            $table->string('juara');
            $table->string('tingkat')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
};
