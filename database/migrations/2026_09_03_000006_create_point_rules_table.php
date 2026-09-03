<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('point_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competency_field_id')->constrained();
            $table->foreignId('activity_type_id')->constrained();
            $table->foreignId('scope_id')->nullable()->constrained('activity_scopes');
            $table->foreignId('role_id')->nullable()->constrained('activity_roles');
            $table->foreignId('achievement_id')->nullable()->constrained('achievement_types');
            $table->unsignedInteger('points');
            $table->unsignedInteger('max_usage')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique([
                'competency_field_id', 'activity_type_id',
                'scope_id', 'role_id', 'achievement_id'
            ], 'point_rules_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_rules');
    }
};
