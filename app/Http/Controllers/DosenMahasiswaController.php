<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Rpk;
use App\Models\Spk;

class DosenMahasiswaController extends Controller
{
    public function index()
{
    $mahasiswa = User::where('dosen_pembimbing_id', Auth::id())
        ->get()
        ->map(function ($mhs) {

            $mhs->total_rpk = Rpk::where('user_id', $mhs->id)->count();

            $mhs->total_spk = Spk::where('user_id', $mhs->id)->count();

            return $mhs;
        });

    return view('dosen.mahasiswa.index', compact('mahasiswa'));
}
}