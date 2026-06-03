<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spks', function (Blueprint $table) {

            $table->foreignId('kegiatan_id')
                  ->after('rpk_id')
                  ->constrained()
                  ->cascadeOnDelete();

        });
    }

    public function down(): void
    {
        Schema::table('spks', function (Blueprint $table) {

            $table->dropForeign(['kegiatan_id']);
            $table->dropColumn('kegiatan_id');

        });
    }
};

