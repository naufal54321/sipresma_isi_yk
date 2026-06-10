<x-app-layout>

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session('success') }}', timer: 2000, showConfirmButton: false });
    </script>
    @endif

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Master Program Studi</h1>
                    <p class="text-gray-500 mt-1">Kelola data program studi untuk registrasi mahasiswa</p>
                </div>
                <button onclick="bukaModalTambah()" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition cursor-pointer">
                    + Tambah Prodi
                </button>
            </div>

            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-center w-16">No</th>
                            <th class="px-6 py-4">Nama Program Studi</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prodis as $prodi)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="px-6 py-4 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $prodi->nama_prodi }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($prodi->status == 'aktif')
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Aktif</span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <button onclick="bukaModalEdit(this)" data-id="{{ $prodi->id }}" data-nama="{{ $prodi->nama_prodi }}" data-status="{{ $prodi->status }}" class="bg-yellow-500 hover:bg-yellow-400 text-white px-3 py-2 rounded-lg text-sm">Edit</button>
                                    <form action="{{ route('admin.prodi.destroy', $prodi->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="hapusProdi(this)" class="bg-red-600 hover:bg-red-500 text-white px-3 py-2 rounded-lg text-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-10 text-gray-400">Belum ada data Program Studi</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function hapusProdi(button) {
    Swal.fire({ title: 'Hapus Prodi?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc2626', confirmButtonText: 'Ya, Hapus' }).then((r) => { if(r.isConfirmed) button.closest('form').submit(); });
}

function htmlFormProdi(prefix) {
    return `
        <div class="mb-4 text-left">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Program Studi *</label>
            <input type="text" name="nama_prodi" id="${prefix}_nama" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" required placeholder="Contoh: S1 Tari">
        </div>
        <div class="mb-4 text-left">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Status *</label>
            <select name="status" id="${prefix}_status" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" required>
                <option value="aktif">Aktif</option>
                <option value="tidak aktif">Tidak Aktif</option>
            </select>
        </div>
    `;
}

function bukaModalTambah() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah Prodi</h2>', width: '500px',
        html: `<form id="formAdd" action="{{ route('admin.prodi.store') }}" method="POST">@csrf ${htmlFormProdi('add')} </form>`,
        showCancelButton: true, confirmButtonText: 'Simpan', confirmButtonColor: '#2563EB', customClass: { popup: 'rounded-2xl p-4' },
        preConfirm: () => {
            if(!document.getElementById('add_nama').value) { Swal.showValidationMessage('Nama prodi wajib diisi!'); return false; }
            document.getElementById('formAdd').submit();
        }
    });
}

function bukaModalEdit(btn) {
    const id = btn.getAttribute('data-id');
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit Prodi</h2>', width: '500px',
        html: `<form id="formEdit" action="{{ url('admin/prodi') }}/${id}" method="POST">@csrf @method('PUT') ${htmlFormProdi('edit')} </form>`,
        showCancelButton: true, confirmButtonText: 'Update', confirmButtonColor: '#D97706', customClass: { popup: 'rounded-2xl p-4' },
        didOpen: () => {
            document.getElementById('edit_nama').value = btn.getAttribute('data-nama');
            document.getElementById('edit_status').value = btn.getAttribute('data-status');
        },
        preConfirm: () => {
            if(!document.getElementById('edit_nama').value) { Swal.showValidationMessage('Nama prodi wajib diisi!'); return false; }
            document.getElementById('formEdit').submit();
        }
    });
}
</script>
</x-app-layout>