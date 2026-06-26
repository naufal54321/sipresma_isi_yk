<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPeranToKegiatanUserTable extends Migration
{
    public function up()
    {
        Schema::table('kegiatan_user', function (Blueprint $table) {
            if (!Schema::hasColumn('kegiatan_user', 'peran')) {
                $table->string('peran')->default('Anggota')->after('user_id');
            }
        });
    }

    public function down()
    {
        Schema::table('kegiatan_user', function (Blueprint $table) {
            $table->dropColumn('peran');
        });
    }
}