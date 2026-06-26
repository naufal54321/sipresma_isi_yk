<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTingkatFromKegiatansTable extends Migration
{
    public function up()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            if (Schema::hasColumn('kegiatans', 'tingkat')) {
                $table->dropColumn('tingkat');
            }
        });
    }

    public function down()
    {
        Schema::table('kegiatans', function (Blueprint $table) {
            if (!Schema::hasColumn('kegiatans', 'tingkat')) {
                $table->string('tingkat')->nullable();
            }
        });
    }
}