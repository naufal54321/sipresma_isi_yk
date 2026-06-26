<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJudulKegiatanToKegiatansTable extends Migration
{
    public function up()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            // Tambah kolom judul_kegiatan jika belum ada
            if (!Schema::hasColumn('kegiatans', 'judul_kegiatan')) {
                $table->string('judul_kegiatan')->nullable()->after('tingkat');
            }
        });
    }

    public function down()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropColumn('judul_kegiatan');
        });
    }
}