<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJudulKegiatanToSpksTable extends Migration
{
    public function up()
    {
        Schema::table('spks', function (Blueprint $table) {
            if (!Schema::hasColumn('spks', 'judul_kegiatan')) {
                $table->string('judul_kegiatan')->nullable()->after('hasil');
            }
        });
    }

    public function down()
    {
        Schema::table('spks', function (Blueprint $table) {
            if (Schema::hasColumn('spks', 'judul_kegiatan')) {
                $table->dropColumn('judul_kegiatan');
            }
        });
    }
}