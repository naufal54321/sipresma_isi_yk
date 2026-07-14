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
        'prestasi_id',
        'hasil',
        'judul_kegiatan',
        'poin',
        'tingkat',
        'url_kegiatan',
        'link_drive',
        'surat_tugas',
        'sertifikat',
        'foto_penyerahan',
        'laporan',
        'judul_karya',
        'biografi',
        'rincian',
        'kebaruan',
        'status',
        'catatan_dosen',
        'poin_added_at',
        'poin_added_by',
    ];

    protected $casts = [
        // ❌ HAPUS: 'tanggal_kegiatan' => 'date',  
        'poin_added_at' => 'datetime',
    ];

    // Relasi ke user
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

    // Relasi ke user yang menambahkan poin
    public function poinAddedBy()
    {
        return $this->belongsTo(User::class, 'poin_added_by');
    }

    // Cek apakah poin sudah ditambahkan
    public function hasPoin()
    {
        return !is_null($this->poin) && $this->poin > 0;
    }

    // Scope untuk SPK disetujui
    public function scopeDisetujui($query)
    {
        return $query->where('status', 'disetujui');
    }

    // Scope untuk SPK dengan poin
    public function scopeDenganPoin($query)
    {
        return $query->where('poin', '>', 0);
    }

    // Scope untuk SPK tanpa poin
    public function scopeTanpaPoin($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('poin')
                ->orWhere('poin', '<=', 0);
        });
    }

    // Relasi ke master prestasi
    public function prestasi()
    {
        return $this->belongsTo(MasterPrestasi::class, 'prestasi_id');
    }
}