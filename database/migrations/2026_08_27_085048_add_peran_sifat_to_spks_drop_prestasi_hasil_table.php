<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spks', function (Blueprint $table) {
            $table->string('peran_sifat')->nullable()->after('kategori');
        });

        Schema::table('spks', function (Blueprint $table) {
            $table->dropForeign(['prestasi_id']);
            $table->dropColumn(['prestasi_id', 'hasil', 'tingkat']);
        });
    }

    public function down(): void
    {
        Schema::table('spks', function (Blueprint $table) {
            $table->foreignId('prestasi_id')->nullable()->after('kategori')->constrained('master_prestasis');
            $table->string('hasil')->nullable()->after('prestasi_id');
            $table->integer('poin')->default(0)->after('hasil');
            $table->string('tingkat')->nullable()->after('poin');
            $table->dropColumn('peran_sifat');
        });
    }
};
