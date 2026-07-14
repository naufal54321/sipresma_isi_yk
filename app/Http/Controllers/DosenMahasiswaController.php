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
        $dosenId = Auth::id();
        $search = $request->search;
        $filterAngkatan = $request->angkatan;

        $mahasiswa = User::where('dosen_pembimbing_id', $dosenId)
            ->withCount(['rpks as total_rpk', 'spks as total_spk'])

            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                      ->orWhere('nim', 'like', '%' . $search . '%')
                      ->orWhere('prodi', 'like', '%' . $search . '%');
                });
            })

            ->when($filterAngkatan, function ($query) use ($filterAngkatan) {
                $query->where('angkatan', $filterAngkatan);
            })

            ->get();

        $listAngkatan = User::where('dosen_pembimbing_id', $dosenId)
            ->whereNotNull('angkatan')
            ->where('angkatan', '!=', '')
            ->distinct()
            ->orderBy('angkatan', 'desc')
            ->pluck('angkatan');

        return view('dosen.mahasiswa.index', compact('mahasiswa', 'listAngkatan'));
    }
}