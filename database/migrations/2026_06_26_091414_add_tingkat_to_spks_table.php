<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTingkatToSpksTable extends Migration
{
    public function up()
    {
        Schema::table('spks', function (Blueprint $table) {
            if (!Schema::hasColumn('spks', 'tingkat')) {
                $table->string('tingkat')->nullable()->after('poin');
            }
        });
    }

    public function down()
    {
        Schema::table('spks', function (Blueprint $table) {
            if (Schema::hasColumn('spks', 'tingkat')) {
                $table->dropColumn('tingkat');
            }
        });
    }
}