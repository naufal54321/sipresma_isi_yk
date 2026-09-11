<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\HasActivity;

class ActivityType extends Model
{
    use HasActivity;

    public function getActivitylogOptions(): \Spatie\Activitylog\Support\LogOptions
    {
        return \Spatie\Activitylog\Support\LogOptions::defaults()
            ->logOnly(['competency_field_id', 'name', 'is_active'])
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    protected $fillable = ['competency_field_id', 'name', 'description', 'evidence_required', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function competencyField()
    {
        return $this->belongsTo(CompetencyField::class);
    }

    public function pointRules()
    {
        return $this->hasMany(PointRule::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
