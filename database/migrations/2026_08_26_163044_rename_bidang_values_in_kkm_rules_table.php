<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Change column to string first (to allow new values)
        Schema::table('kkm_rules', function (Blueprint $table) {
            $table->string('bidang')->change();
        });

        // Step 2: Update existing data
        DB::table('kkm_rules')->where('bidang', 'Kompetensi Profesional')->update(['bidang' => 'Bidang Orientasi Kompetensi Profesional']);
        DB::table('kkm_rules')->where('bidang', 'Kompetensi Kepribadian dan Sosial')->update(['bidang' => 'Bidang Kompetensi Kepribadian dan Sosial']);

        // Step 3: Change back to enum with new values
        Schema::table('kkm_rules', function (Blueprint $table) {
            $table->enum('bidang', [
                'Bidang Orientasi Kompetensi Profesional',
                'Bidang Kompetensi Kepribadian dan Sosial',
            ])->change();
        });
    }

    public function down(): void
    {
        Schema::table('kkm_rules', function (Blueprint $table) {
            $table->string('bidang')->change();
        });

        DB::table('kkm_rules')->where('bidang', 'Bidang Orientasi Kompetensi Profesional')->update(['bidang' => 'Kompetensi Profesional']);
        DB::table('kkm_rules')->where('bidang', 'Bidang Kompetensi Kepribadian dan Sosial')->update(['bidang' => 'Kompetensi Kepribadian dan Sosial']);

        Schema::table('kkm_rules', function (Blueprint $table) {
            $table->enum('bidang', [
                'Kompetensi Profesional',
                'Kompetensi Kepribadian dan Sosial',
            ])->change();
        });
    }
};
