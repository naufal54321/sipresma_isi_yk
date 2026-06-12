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
        Schema::table('rpks', function (Blueprint $table) {
    $table->enum('status', [
        'draft',
        'disetujui',
        'ditolak'
    ])->default('draft');

    $table->text('catatan_dosen')->nullable();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rpks', function (Blueprint $table) {
            //
        });
    }
};
