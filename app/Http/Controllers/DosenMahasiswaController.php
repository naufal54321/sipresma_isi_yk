<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rpk;
use App\Models\Spk;
use Illuminate\Support\Facades\Auth;

class DosenMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $mahasiswa = User::where('dosen_pembimbing_id', Auth::id())

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('nim', 'like', '%' . $search . '%')
                      ->orWhere('prodi', 'like', '%' . $search . '%');
                });
            })

            ->get()

            ->map(function ($mhs) {

                $mhs->total_rpk = Rpk::where('user_id', $mhs->id)->count();

                $mhs->total_spk = Spk::where('user_id', $mhs->id)->count();

                return $mhs;
            });

        return view('dosen.mahasiswa.index', compact('mahasiswa'));
    }
}