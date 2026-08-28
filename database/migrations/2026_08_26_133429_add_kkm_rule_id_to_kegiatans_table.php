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
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->foreignId('kkm_rule_id')->nullable()->after('master_kegiatan_id')->constrained()->nullOnDelete();
            $table->integer('poin_kkm')->nullable()->after('kkm_rule_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropForeign(['kkm_rule_id']);
            $table->dropColumn(['kkm_rule_id', 'poin_kkm']);
        });
    }
};
