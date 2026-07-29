<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan', 
        'status'
    ];

    protected $casts = [
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function rpks()
{
    return $this->hasMany(Rpk::class);
}

public function kegiatans()
{
    return $this->hasMany(Kegiatan::class);
}

}