<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTingkatFromMasterKegiatansTable extends Migration
{
    public function up()
    {
        Schema::table('master_kegiatans', function (Blueprint $table) {
            if (Schema::hasColumn('master_kegiatans', 'tingkat')) {
                $table->dropColumn('tingkat');
            }
        });
    }

    public function down()
    {
        Schema::table('master_kegiatans', function (Blueprint $table) {
            if (!Schema::hasColumn('master_kegiatans', 'tingkat')) {
                $table->string('tingkat')->nullable();
            }
        });
    }
}