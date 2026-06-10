<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
    'rpk_id',
    'master_kegiatan_id',
    'kegiatan',
    'jenis',
    'tingkat',
    'hasil',
    'tanggal',
    'kategori',
    'peran',
    'jumlah_anggota',
    'status',
    'catatan_dosen'
];

public function rpk()
{
    return $this->belongsTo(Rpk::class);
}
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
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
