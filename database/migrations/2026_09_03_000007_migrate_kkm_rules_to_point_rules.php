<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('kkm_rules')) return;

        $bidangMap = [
            'Bidang Orientasi Kompetensi Profesional' => 1,
            'Bidang Kompetensi Kepribadian dan Sosial' => 2,
        ];

        $scopeMap = [
            'Tidak Ada / Statis' => 1,
            'Program Studi' => 2,
            'Fakultas' => 3,
            'Kampus' => 4,
            'Institut/Kampus' => 5,
            'Institut' => 5,
            'Lokal (DIY & Sekitarnya)' => 6,
            'Lokal' => 6,
            'Nasional' => 7,
            'Internasional' => 8,
        ];

        $roleCache = [];
        $oldToNewId = [];

        $rules = DB::table('kkm_rules')->where('is_active', true)->get();

        foreach ($rules as $rule) {
            $competencyFieldId = $bidangMap[$rule->bidang] ?? null;
            if (!$competencyFieldId) continue;

            $activityType = DB::table('activity_types')
                ->where('competency_field_id', $competencyFieldId)
                ->where('name', $rule->jenis_kegiatan)
                ->first();
            if (!$activityType) continue;

            $scopeId = null;
            if ($rule->ruang_lingkup) {
                $scopeId = $scopeMap[$rule->ruang_lingkup] ?? null;
            }

            $roleName = $rule->peran;
            if (!isset($roleCache[$roleName])) {
                $existing = DB::table('activity_roles')->where('name', $roleName)->first();
                if ($existing) {
                    $roleCache[$roleName] = $existing->id;
                } else {
                    $roleCache[$roleName] = DB::table('activity_roles')->insertGetId([
                        'name' => $roleName,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            $roleId = $roleCache[$roleName];

            $achievementId = null;
            if ($rule->hasil) {
                $existing = DB::table('achievement_types')->where('name', $rule->hasil)->first();
                if ($existing) {
                    $achievementId = $existing->id;
                } else {
                    $achievementId = DB::table('achievement_types')->insertGetId([
                        'name' => $rule->hasil,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            $exists = DB::table('point_rules')
                ->where('competency_field_id', $competencyFieldId)
                ->where('activity_type_id', $activityType->id)
                ->where('scope_id', $scopeId)
                ->where('role_id', $roleId)
                ->where('achievement_id', $achievementId)
                ->exists();

            if (!$exists) {
                $newId = DB::table('point_rules')->insertGetId([
                    'competency_field_id' => $competencyFieldId,
                    'activity_type_id' => $activityType->id,
                    'scope_id' => $scopeId,
                    'role_id' => $roleId,
                    'achievement_id' => $achievementId,
                    'points' => $rule->poin,
                    'max_usage' => 4,
                    'is_active' => $rule->is_active,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $oldToNewId[$rule->id] = $newId;
            } else {
                $newRow = DB::table('point_rules')
                    ->where('competency_field_id', $competencyFieldId)
                    ->where('activity_type_id', $activityType->id)
                    ->where('scope_id', $scopeId)
                    ->where('role_id', $roleId)
                    ->where('achievement_id', $achievementId)
                    ->first();
                $oldToNewId[$rule->id] = $newRow->id;
            }
        }

        // Map old kkm_rule_id values to new point_rules IDs
        if (!empty($oldToNewId)) {
            foreach ($oldToNewId as $oldId => $newId) {
                DB::table('kegiatans')
                    ->where('point_rule_id', $oldId)
                    ->update(['point_rule_id' => $newId]);
            }
        }

        // Handle column rename (idempotent)
        if (Schema::hasColumn('kegiatans', 'kkm_rule_id')) {
            Schema::table('kegiatans', function (Blueprint $table) {
                $table->dropForeign(['kkm_rule_id']);
                $table->renameColumn('kkm_rule_id', 'point_rule_id');
            });
        }

        // Add FK if not already present
        $hasFk = Schema::getColumns('kegiatans')
            && collect(Schema::getColumns('kegiatans'))->contains('point_rule_id');
        if ($hasFk) {
            $fkName = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = '" . DB::getDatabaseName() . "' AND TABLE_NAME = 'kegiatans' AND COLUMN_NAME = 'point_rule_id' AND REFERENCED_TABLE_NAME = 'point_rules' LIMIT 1");
            if (empty($fkName)) {
                Schema::table('kegiatans', function (Blueprint $table) {
                    $table->foreign('point_rule_id')->references('id')->on('point_rules')->nullOnDelete();
                });
            }
        }

        if (Schema::hasColumn('kegiatans', 'master_kegiatan_id')) {
            Schema::table('kegiatans', function (Blueprint $table) {
                $table->dropColumn('master_kegiatan_id');
            });
        }

        if (Schema::hasColumn('rpks', 'master_kegiatan_id')) {
            Schema::table('rpks', function (Blueprint $table) {
                $table->dropColumn('master_kegiatan_id');
            });
        }

        Schema::dropIfExists('kkm_rules');
    }

    public function down(): void
    {
        Schema::create('kkm_rules', function (Blueprint $table) {
            $table->id();
            $table->enum('bidang', [
                'Bidang Orientasi Kompetensi Profesional',
                'Bidang Kompetensi Kepribadian dan Sosial',
            ]);
            $table->string('jenis_kegiatan');
            $table->string('ruang_lingkup')->nullable();
            $table->string('peran');
            $table->string('hasil')->nullable();
            $table->integer('poin');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropForeign(['point_rule_id']);
            $table->renameColumn('point_rule_id', 'kkm_rule_id');
            $table->foreign('kkm_rule_id')->references('id')->on('kkm_rules')->nullOnDelete();
        });

        Schema::dropIfExists('point_rules');
        Schema::dropIfExists('achievement_types');
        Schema::dropIfExists('activity_roles');
        Schema::dropIfExists('activity_scopes');
        Schema::dropIfExists('activity_types');
        Schema::dropIfExists('competency_fields');
    }
};
