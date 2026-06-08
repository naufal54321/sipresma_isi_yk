<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterKegiatan extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'jenis',
        'tingkat',
        'hasil',
        'poin',
        'status'
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