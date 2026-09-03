<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
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
