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

        if (!Schema::hasColumn('kegiatans', 'master_kegiatan_id')) {

            $table->foreignId('master_kegiatan_id')
                  ->nullable()
                  ->after('rpk_id');

        }

    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            //
        });
    }
};
