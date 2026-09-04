<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileRequirement extends Model
{
    protected $fillable = [
        'point_rule_id',
        'file_column',
        'label',
        'accept',
        'is_required',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function pointRule()
    {
        return $this->belongsTo(PointRule::class);
    }
}
