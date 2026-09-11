<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Concerns\HasActivity;

class Rpk extends Model
{
    use HasActivity;

    public function getActivitylogOptions(): \Spatie\Activitylog\Support\LogOptions
    {
        return \Spatie\Activitylog\Support\LogOptions::defaults()
            ->logOnly(['status', 'dosen_pembimbing_id', 'catatan_dosen'])
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at']);
    }

    protected $fillable = [
        'user_id',
        'dosen_pembimbing_id',
        'tahun',
        'semester',
        'status',
        'catatan_dosen',
        'verified_by',
        'verified_at',
    ];

    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

public function user()
{
    return $this->belongsTo(User::class);
}

public function kegiatans()
{
    return $this->hasMany(Kegiatan::class);
}



public function spks()
{
    return $this->hasMany(Spk::class);
}

public function verifiedBy()
{
    return $this->belongsTo(User::class, 'verified_by');
}

public function dosenPembimbing()
{
    return $this->belongsTo(User::class, 'dosen_pembimbing_id');
}

}
