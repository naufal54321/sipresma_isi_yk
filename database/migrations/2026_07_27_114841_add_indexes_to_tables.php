<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('spks', function (Blueprint $table) {
            $table->index('status');
            $table->index('tahun');
        });

        Schema::table('rpks', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('spks', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['tahun']);
        });

        Schema::table('rpks', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
