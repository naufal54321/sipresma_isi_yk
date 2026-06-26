<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTingkatToMasterPrestasisTable extends Migration
{
    public function up()
    {
        Schema::table('master_prestasis', function (Blueprint $table) {
            if (!Schema::hasColumn('master_prestasis', 'tingkat')) {
                $table->string('tingkat')->nullable()->after('poin');
            }
        });
    }

    public function down()
    {
        Schema::table('master_prestasis', function (Blueprint $table) {
            if (Schema::hasColumn('master_prestasis', 'tingkat')) {
                $table->dropColumn('tingkat');
            }
        });
    }
}