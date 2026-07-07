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

        <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Ploting Dosen Pembimbing</h1>
                <p class="text-gray-500 mt-1">Atur dan kelola dosen pembimbing untuk setiap mahasiswa secara spesifik</p>
            </div>

            <form method="GET" action="{{ route('admin.pembimbing.index') }}" class="flex w-full md:w-auto items-center gap-2">
                <div class="relative w-full md:w-64">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari Nama atau NIM..." 
                           class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition shadow-sm">
                    <i class="fas fa-search absolute left-3.5 top-3.5 text-gray-400"></i>
                </div>
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm whitespace-nowrap">
                    Cari
                </button>
                
                @if(request('search'))
                    <a href="{{ route('admin.pembimbing.index') }}" class="bg-slate-500 hover:bg-slate-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm flex items-center justify-center whitespace-nowrap">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    
                    <thead class="bg-slate-50 uppercase text-xs tracking-wider border-b border-gray-200 text-slate-500">
                        <tr>
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th class="px-6 py-4">Mahasiswa</th>
                            <th class="px-6 py-4">NIM</th>
                            <th class="px-6 py-4">Prodi</th>
                            <th class="px-6 py-4">Dosen Pembimbing</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="tableBody" class="divide-y divide-gray-100">
                        @forelse($mahasiswa as $mhs)
                        <tr data-mahasiswa-id="{{ $mhs->id }}" class="hover:bg-blue-50/50 transition duration-200 group">
                            
                            <td class="px-6 py-4 text-center font-medium text-gray-900">
                                {{ ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() + $loop->iteration }}
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $mhs->name }}</div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded text-slate-600">{{ $mhs->nim }}</span>
                            </td>
                            
                            <td class="px-6 py-4">
                                {{ $mhs->prodi }}
                            </td>
                            
                            <td class="px-6 py-4 font-medium {{ $mhs->dosen_pembimbing_id ? 'text-blue-600' : 'text-gray-400 italic' }}">
                                {{ $mhs->dosenPembimbing->name ?? 'Belum Diplot' }}
                            </td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($mhs->dosen_pembimbing_id)
                                    <span class="inline-block min-w-[90px] text-center bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide uppercase">
                                        Ada
                                    </span>
                                @else
                                    <span class="inline-block min-w-[90px] text-center bg-rose-50 text-rose-600 border border-rose-200 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide uppercase">
                                        Kosong
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                               <button type="button" 
                                    onclick="bukaModalPlotting('{{ $mhs->id }}', '{{ e($mhs->name) }}', '{{ $mhs->dosen_pembimbing_id ?? '' }}')"
                                    class="inline-flex items-center justify-center gap-2 bg-white border border-gray-300 hover:border-blue-500 hover:bg-blue-50 text-gray-700 hover:text-blue-600 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all shadow-sm whitespace-nowrap w-full">
                                    <i class="fas fa-user-tie"></i> Atur Dosen
                                </button>
                            </td>

                        </tr>
                        @empty
                        <tr id="emptyRow">
                            <td colspan="7" class="text-center py-12">
                                <div class="text-gray-400 mb-2"><i class="fas fa-folder-open text-3xl"></i></div>
                                <span class="text-gray-500 font-medium">Belum ada data mahasiswa yang cocok dengan pencarian</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            @if($mahasiswa->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-slate-50/50">
                {{ $mahasiswa->withQueryString()->links() }}
            </div>
            @endif

        </div>

    </div>

    <select id="template_dosen" class="hidden">
        <option value="">-- Kosongkan untuk Hapus Dosen --</option>
        @foreach($dosen as $dsn)
            <option value="{{ $dsn->id }}">{{ $dsn->name }}</option>
        @endforeach
    </select>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // ⚡ Daftar dosen untuk lookup nama
        const dosenList = {
            @foreach($dosen as $dsn)
                "{{ $dsn->id }}": "{{ e($dsn->name) }}",
            @endforeach
        };

        function bukaModalPlotting(mahasiswaId, namaMahasiswa, currentDosenId) {
            const opsiDosen = document.getElementById('template_dosen').innerHTML;

            Swal.fire({
                title: '<h2 class="text-xl font-bold text-gray-800 text-left">Atur Dosen Pembimbing</h2>',
                html: `
                    <div class="text-left mt-4">
                        <div class="mb-4 p-3 bg-slate-50 rounded-xl border border-slate-200">
                            <span class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Mahasiswa</span>
                            <span class="block text-base font-bold text-slate-800">${namaMahasiswa}</span>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Dosen Pembimbing</label>
                            <select id="pilih_dosen" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                ${opsiDosen}
                            </select>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan Ploting',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#2563EB',
                cancelButtonColor: '#9CA3AF',
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: { popup: 'rounded-2xl p-4' },
                didOpen: () => {
                    if (currentDosenId) {
                        document.getElementById('pilih_dosen').value = currentDosenId;
                    }
                },
                preConfirm: () => {
                    const dosenId = document.getElementById('pilih_dosen').value;
                    
                    // ⚡ Tampilkan loading
                    Swal.showLoading();
                    
                    // ⚡ Kirim via AJAX (fetch)
                    return fetch('{{ route("admin.pembimbing.set") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            mahasiswa_id: mahasiswaId,
                            dosen_id: dosenId || null
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success || data.message === 'success') {
                            return { dosenId, dosenName: dosenList[dosenId] || null };
                        }
                        throw new Error(data.message || 'Gagal menyimpan ploting');
                    })
                    .catch(error => {
                        Swal.showValidationMessage(error.message);
                        return false;
                    });
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const { dosenId, dosenName } = result.value;
                    
                    // ⚡ Update row langsung tanpa reload
                    const row = document.querySelector(`tr[data-mahasiswa-id="${mahasiswaId}"]`);
                    if (row) {
                        const cells = row.querySelectorAll('td');
                        
                        // Update Dosen Pembimbing (index 4)
                        if (dosenId) {
                            cells[4].innerHTML = dosenName;
                            cells[4].className = 'px-6 py-4 font-medium text-blue-600';
                        } else {
                            cells[4].innerHTML = 'Belum Diplot';
                            cells[4].className = 'px-6 py-4 font-medium text-gray-400 italic';
                        }
                        
                        // Update Status (index 5)
                        if (dosenId) {
                            cells[5].innerHTML = '<span class="inline-block min-w-[90px] text-center bg-emerald-50 text-emerald-600 border border-emerald-200 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide uppercase">Ada</span>';
                        } else {
                            cells[5].innerHTML = '<span class="inline-block min-w-[90px] text-center bg-rose-50 text-rose-600 border border-rose-200 px-3 py-1 rounded-full text-[11px] font-bold tracking-wide uppercase">Kosong</span>';
                        }
                        
                        // Update data attribute untuk tombol
                        const btn = row.querySelector('button');
                        if (btn) {
                            btn.setAttribute('onclick', `bukaModalPlotting('${mahasiswaId}', '${namaMahasiswa}', '${dosenId || ''}')`);
                        }
                    }
                    
                    const pesan = dosenId 
                        ? 'Dosen pembimbing berhasil diatur.' 
                        : 'Dosen pembimbing berhasil dihapus.';
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: pesan,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        }
    </script>

</x-app-layout>