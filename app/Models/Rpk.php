<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rpk extends Model
{
    protected $fillable = [
        'user_id',
        'master_kegiatan_id',
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

public function masterKegiatan()
{
    return $this->belongsTo(MasterKegiatan::class);
}

public function verifiedBy()
{
    return $this->belongsTo(User::class, 'verified_by');
}

}
