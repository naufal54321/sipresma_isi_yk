<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rpks', function (Blueprint $table) {
            if (!Schema::hasColumn('rpks', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
        });

        Schema::table('spks', function (Blueprint $table) {
            if (!Schema::hasColumn('spks', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
        });

        DB::table('rpks')
            ->whereNotNull('verified_by')
            ->whereNull('verified_at')
            ->update(['verified_at' => DB::raw('updated_at')]);

        DB::table('spks')
            ->whereNotNull('verified_by')
            ->whereNull('verified_at')
            ->update(['verified_at' => DB::raw('updated_at')]);
    }

    public function down(): void
    {
        Schema::table('rpks', function (Blueprint $table) {
            if (Schema::hasColumn('rpks', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
        });

        Schema::table('spks', function (Blueprint $table) {
            if (Schema::hasColumn('spks', 'verified_at')) {
                $table->dropColumn('verified_at');
            }
        });
    }
};