<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom dosen_pembimbing_id ke tabel rpks
        Schema::table('rpks', function (Blueprint $table) {
            $table->foreignId('dosen_pembimbing_id')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
        });

        // 2. Copy data dari users.dosen_pembimbing_id ke rpks.dosen_pembimbing_id
        DB::statement('
            UPDATE rpks
            INNER JOIN users ON users.id = rpks.user_id
            SET rpks.dosen_pembimbing_id = users.dosen_pembimbing_id
            WHERE users.dosen_pembimbing_id IS NOT NULL
        ');

        // 3. Drop kolom dosen_pembimbing_id dari tabel users
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['dosen_pembimbing_id']);
            $table->dropColumn('dosen_pembimbing_id');
        });
    }

    public function down(): void
    {
        // Reverse: tambah kolom kembali ke users
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('dosen_pembimbing_id')->nullable()->after('is_approved')->constrained('users')->nullOnDelete();
        });

        // Copy data kembali
        DB::statement('
            UPDATE users
            INNER JOIN rpks ON rpks.user_id = users.id AND rpks.dosen_pembimbing_id IS NOT NULL
            SET users.dosen_pembimbing_id = rpks.dosen_pembimbing_id
        ');

        // Drop dari rpks
        Schema::table('rpks', function (Blueprint $table) {
            $table->dropForeign(['dosen_pembimbing_id']);
            $table->dropColumn('dosen_pembimbing_id');
        });
    }
};
