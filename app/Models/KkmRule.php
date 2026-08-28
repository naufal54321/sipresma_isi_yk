<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KkmRule extends Model
{
    protected $fillable = [
        'bidang',
        'jenis_kegiatan',
        'ruang_lingkup',
        'peran',
        'hasil',
        'poin',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
