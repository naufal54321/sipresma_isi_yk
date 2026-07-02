<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Detail RPK
                </h1>
                <p class="text-gray-500 mt-1">
                    Daftar kegiatan pada RPK
                </p>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('rpks.index') }}"
                   class="bg-gray-500 hover:bg-gray-400 text-white px-5 py-2 rounded-xl text-sm font-semibold transition">
                    ← Kembali
                </a>

                <button onclick="bukaModalTambahKegiatan()"
                   class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition cursor-pointer">
                    + Tambah Kegiatan
                </button>
            </div>
        </div>


        <div class="bg-white shadow rounded-2xl p-6 mb-6">
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Tahun</p>
                    <h1 class="text-lg font-bold text-gray-800">{{ $rpk->tahun }}</h1>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Semester</p>
                    <h1 class="text-lg font-bold text-gray-800">{{ $rpk->semester }}</h1>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kategori</p>
                    <h1 class="text-lg font-bold text-gray-800">{{ $rpk->kategori }}</h1>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Tingkat</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Catatan Dosen</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rpk->kegiatans as $kegiatan)
                    <tr class="border-b hover:bg-blue-50 transition">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">{{ $kegiatan->kegiatan }}</td>
                        <td class="px-6 py-4">{{ $kegiatan->tingkat }}</td>
                        <td class="px-6 py-4">{{ $kegiatan->kategori }}</td>
                        <td class="px-6 py-4">
                            @if($kegiatan->status == 'draft')
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs">Draft</span>
                            @elseif($kegiatan->status == 'disetujui')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">Disetujui</span>
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($kegiatan->catatan_dosen)
                                <span class="text-gray-700">{{ $kegiatan->catatan_dosen }}</span>
                            @else
                                <span class="text-gray-400 italic">Belum ada catatan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ $kegiatan->poin ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($kegiatan->status == 'draft' || $kegiatan->status == 'ditolak')
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('kegiatans.edit', $kegiatan->id) }}"
                                   class="bg-yellow-500 hover:bg-yellow-400 text-white px-3 py-2 rounded-lg text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('kegiatans.destroy', $kegiatan->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                            onclick="hapusKegiatan(this)"
                                            class="bg-red-600 hover:bg-red-500 text-white px-3 py-2 rounded-lg text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-gray-400">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-10 text-gray-400">
                            Belum ada kegiatan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// --- Script Hapus Kegiatan ---
function hapusKegiatan(button) {
    Swal.fire({
        title: 'Hapus Kegiatan?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            button.closest('form').submit();
        }
    });
}

// --- Script Tambah Kegiatan (Modal Kompleks) ---
function bukaModalTambahKegiatan() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah Kegiatan</h2>',
        width: '600px',
        html: `
            <form id="formTambahKegiatan" action="{{ route('kegiatans.store', $rpk->id) }}" method="POST" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Kegiatan *</label>
                    <select name="master_kegiatan_id" id="swal_master_kegiatan_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                        <option value="">Pilih Kegiatan</option>
                        @foreach($masterKegiatans as $item)
                        <option value="{{ $item->id }}"
                                data-jenis="{{ $item->jenis }}"
                                data-tingkat="{{ $item->tingkat }}">
                            {{ $item->nama_kegiatan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Jenis</label>
                        <input type="text" id="swal_jenis" name="jenis" class="w-full bg-gray-50 border border-gray-300 text-gray-500 rounded-lg p-2 outline-none" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tingkat</label>
                        <input type="text" id="swal_tingkat" name="tingkat" class="w-full bg-gray-50 border border-gray-300 text-gray-500 rounded-lg p-2 outline-none" readonly>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil / Prestasi *</label>
                    <select name="prestasi_id" id="swal_prestasi_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                        <option value="">-- Pilih Hasil / Juara --</option>
                        @foreach(\App\Models\MasterPrestasi::where('is_active', true)->get() as $prestasi)
                            <option value="{{ $prestasi->id }}">{{ $prestasi->juara }} ({{ $prestasi->poin }} Poin)</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal *</label>
                    <input type="date" id="swal_tanggal" name="tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori *</label>
                    <select name="kategori" id="swal_kategori" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                        <option value="">Pilih Kategori</option>
                        <option value="Individu">Individu</option>
                        <option value="Kelompok">Kelompok</option>
                    </select>
                </div>

                <div class="mb-4 hidden" id="swal_peranField">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Peran</label>
                    <select name="peran" id="swal_peran" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none">
                        <option value="">Pilih Peran</option>
                        <option value="Ketua">Ketua</option>
                        <option value="Anggota">Anggota</option>
                    </select>
                </div>

                <div class="mb-4 hidden" id="swal_jumlahAnggotaField">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Anggota</label>
                    <input type="number" id="swal_jumlah_anggota" name="jumlah_anggota" min="1" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none">
                </div>

            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#9CA3AF',
        customClass: { popup: 'rounded-2xl p-4' },
        didOpen: () => {
            const masterId = document.getElementById('swal_master_kegiatan_id');
            const kategori = document.getElementById('swal_kategori');
            const peran = document.getElementById('swal_peran');
            const peranField = document.getElementById('swal_peranField');
            const jumlahAnggotaField = document.getElementById('swal_jumlahAnggotaField');

            // Hapus referensi data-hasil dan data-poin
            masterId.addEventListener('change', function() {
                let selected = this.options[this.selectedIndex];
                document.getElementById('swal_jenis').value = selected.dataset.jenis || '';
                document.getElementById('swal_tingkat').value = selected.dataset.tingkat || '';
            });

            kategori.addEventListener('change', function() {
                if(this.value === 'Kelompok') {
                    peranField.classList.remove('hidden');
                } else {
                    peranField.classList.add('hidden');
                    jumlahAnggotaField.classList.add('hidden');
                    peran.value = '';
                    document.getElementById('swal_jumlah_anggota').value = '';
                }
            });

            peran.addEventListener('change', function() {
                if(this.value === 'Ketua') {
                    jumlahAnggotaField.classList.remove('hidden');
                } else {
                    jumlahAnggotaField.classList.add('hidden');
                    document.getElementById('swal_jumlah_anggota').value = '';
                }
            });
        },
        preConfirm: () => {
            const master = document.getElementById('swal_master_kegiatan_id').value;
            const prestasi = document.getElementById('swal_prestasi_id').value; // Tambahkan ini
            const tgl = document.getElementById('swal_tanggal').value;
            const kat = document.getElementById('swal_kategori').value;
            const per = document.getElementById('swal_peran').value;
            const jml = document.getElementById('swal_jumlah_anggota').value;

            if (!master || !prestasi || !tgl || !kat) {
                Swal.showValidationMessage('Kegiatan, Prestasi, Tanggal, dan Kategori wajib diisi!');
                return false;
            }
            if (kat === 'Kelompok' && !per) {
                Swal.showValidationMessage('Karena Kelompok, harap pilih Peran!');
                return false;
            }
            if (kat === 'Kelompok' && per === 'Ketua' && !jml) {
                Swal.showValidationMessage('Karena Anda Ketua, harap isi Jumlah Anggota!');
                return false;
            }

            document.getElementById('formTambahKegiatan').submit();
        }
    });
}
</script>

</x-app-layout>