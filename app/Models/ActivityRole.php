<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\HasActivity;

class ActivityRole extends Model
{
    use HasActivity;

    public function getActivitylogOptions(): \Spatie\Activitylog\Support\LogOptions
    {
        return \Spatie\Activitylog\Support\LogOptions::defaults()
            ->logOnly(['name', 'is_active'])
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    protected $fillable = ['name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pointRules()
    {
        return $this->hasMany(PointRule::class, 'role_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
