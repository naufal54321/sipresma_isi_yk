<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rpk extends Model
{
    protected $fillable = [
    'user_id',
    'tahun',
    'semester',
    'kategori'
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

}
