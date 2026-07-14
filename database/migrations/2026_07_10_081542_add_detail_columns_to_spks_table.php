<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spks', function (Blueprint $table) {
            $table->string('judul_karya')->nullable()->after('keterangan');
            $table->text('biografi')->nullable()->after('judul_karya');
            $table->text('rincian')->nullable()->after('biografi');
            $table->text('kebaruan')->nullable()->after('rincian');
        });
    }

    public function down(): void
    {
        Schema::table('spks', function (Blueprint $table) {
            $table->dropColumn(['judul_karya', 'biografi', 'rincian', 'kebaruan']);
        });
    }
};