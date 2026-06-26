<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('spks', function (Blueprint $table) {
        if (!Schema::hasColumn('spks', 'prestasi_id')) {
            $table->foreignId('prestasi_id')->nullable()->after('kategori')->constrained('master_prestasis');
        }
        if (!Schema::hasColumn('spks', 'hasil')) {
            $table->string('hasil')->nullable()->after('prestasi_id');
        }
        if (!Schema::hasColumn('spks', 'poin')) {
            $table->integer('poin')->default(0)->after('hasil');
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spks', function (Blueprint $table) {
            //
        });
    }
};
