<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spk extends Model
{
    protected $fillable = [
        'user_id',
        'rpk_id',
        'kegiatan_id',
        'tahun',
        'tanggal_kegiatan',
        'penyelenggara',
        'kategori',
        'url_kegiatan',
        'bukti',
        'keterangan',
        'status',
        'catatan_dosen'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rpk()
    {
        return $this->belongsTo(Rpk::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}