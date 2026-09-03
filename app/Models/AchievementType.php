<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchievementType extends Model
{
    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pointRules()
    {
        return $this->hasMany(PointRule::class, 'achievement_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
