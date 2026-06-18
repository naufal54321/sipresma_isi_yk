<x-app-layout>

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    </script>
    @endif

    <div class="max-w-8xl mx-auto py-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Ploting Dosen Pembimbing</h1>
            <p class="text-gray-500 mt-1">Atur dan kelola dosen pembimbing untuk setiap mahasiswa</p>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">

            <div class="p-6 bg-gray-50/50 border-b border-gray-200">
                <form method="POST" action="{{ route('admin.pembimbing.set') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Mahasiswa *</label>
                            <select name="mahasiswa_id" 
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition" 
                                    required>
                                <option value="">-- Pilih Mahasiswa --</option>
                                @foreach($mahasiswa as $mhs)
                                    <option value="{{ $mhs->id }}">
                                        {{ $mhs->name }} - {{ $mhs->nim }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('mahasiswa_id')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Dosen Pembimbing</label>
                            <select name="dosen_id" 
                                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition">
                                <option value="">
                                    -- Kosongkan untuk Hapus Dosen --
                                </option>
                                @foreach($dosen as $dsn)
                                    <option value="{{ $dsn->id }}"
                                        {{ old('dosen_id') == $dsn->id ? 'selected' : '' }}>
                                        {{ $dsn->name }}
                                    </option>
                                @endforeach
                            </select>
                            
                            @error('dosen_id')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end md:justify-start">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition w-full md:w-auto cursor-pointer shadow-sm">
                            Simpan / Update
                        </button>
                    </div>

                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    
                    <thead class="bg-gray-100 uppercase text-xs tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th class="px-6 py-4">Mahasiswa</th>
                            <th class="px-6 py-4">NIM</th>
                            <th class="px-6 py-4">Prodi</th>
                            <th class="px-6 py-4">Dosen Pembimbing</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($mahasiswa as $mhs)
                        <tr class="hover:bg-blue-50 transition duration-200">
                            
                            <td class="px-6 py-4 text-center font-medium text-gray-900">
                                {{ $loop->iteration }}
                            </td>
                            
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $mhs->name }}
                            </td>
                            
                            <td class="px-6 py-4">
                                {{ $mhs->nim }}
                            </td>
                            
                            <td class="px-6 py-4">
                                {{ $mhs->prodi }}
                            </td>
                            
                            <td class="px-6 py-4 font-medium {{ $mhs->dosen_pembimbing_id ? 'text-blue-600' : 'text-gray-400 italic' }}">
                                {{ $mhs->dosenPembimbing->name ?? 'Belum Diplot' }}
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($mhs->dosen_pembimbing_id)
                                    <span class="inline-block min-w-[90px] text-center bg-green-100 text-green-700 border px-3 py-1 rounded-full text-xs font-semibold">
                                        Sudah Ada
                                    </span>
                                @else
                                    <span class="inline-block min-w-[90px] text-center bg-red-100 text-red-700 border px-3 py-1 rounded-full text-xs font-semibold">
                                        Tidak Ada
                                    </span>
                                @endif
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-10 text-gray-400">
                                Belum ada data mahasiswa
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            </div>

    </div>

</x-app-layout>