<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_prestasis', function (Blueprint $table) {
            if (Schema::hasColumn('master_prestasis', 'poin')) {
                $table->dropColumn('poin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('master_prestasis', function (Blueprint $table) {
            $table->integer('poin')->default(0)->after('tingkat');
        });
    }
};