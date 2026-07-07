<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPrestasi extends Model
{
    use HasFactory;
    
    // 🔧 PASTIKAN is_active ADA DI $fillable
    protected $fillable = [
        'juara',
        'tingkat', 
        'is_active', // ⚡ HARUS ADA
    ];
    
    // ATAU gunakan guarded (lebih simpel)
    // protected $guarded = ['id'];
    
    // 🔧 Casting untuk memastikan tipe data boolean
    protected $casts = [
        'is_active' => 'boolean', // ⚡ OPSIONAL tapi disarankan
    ];
}