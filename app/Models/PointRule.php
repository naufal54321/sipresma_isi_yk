<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointRule extends Model
{
    protected $table = 'point_rules';

    protected $fillable = [
        'competency_field_id',
        'activity_type_id',
        'scope_id',
        'role_id',
        'achievement_id',
        'points',
        'max_usage',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'points' => 'integer',
        'max_usage' => 'integer',
    ];

    public function competencyField()
    {
        return $this->belongsTo(CompetencyField::class);
    }

    public function activityType()
    {
        return $this->belongsTo(ActivityType::class);
    }

    public function scope()
    {
        return $this->belongsTo(ActivityScope::class, 'scope_id');
    }

    public function role()
    {
        return $this->belongsTo(ActivityRole::class, 'role_id');
    }

    public function achievement()
    {
        return $this->belongsTo(AchievementType::class, 'achievement_id');
    }

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'point_rule_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFullPathAttribute(): string
    {
        $parts = [
            $this->competencyField->name ?? '-',
            $this->activityType->name ?? '-',
            $this->scope->name ?? '-',
            $this->role->name ?? '-',
        ];
        return implode(' → ', $parts);
    }
}
