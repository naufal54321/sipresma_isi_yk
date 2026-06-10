<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Data SPK
                </h1>

                <p class="text-gray-500">
                    Surat Pengajuan Kegiatan
                </p>
            </div>

            <button onclick="bukaModalTambahSPK()"
               class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-xl text-sm font-semibold transition cursor-pointer">
                + Tambah SPK
            </button>

        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">RPK</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Catatan Dosen</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($spks as $spk)

                    <tr class="border-b hover:bg-blue-50 transition">

                        <td class="px-6 py-4 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->tahun }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->rpk->tahun ?? '-' }} - {{ $spk->rpk->semester ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->kegiatan->kegiatan ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->kegiatan->jenis ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($spk->status == 'draft')
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Draft
                                </span>
                            @elseif($spk->status == 'disetujui')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Disetujui
                                </span>
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Ditolak
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->catatan_dosen ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                               <a href="{{ route('spks.show', $spk->id) }}"
   class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-2 rounded-lg text-sm">
    Detail
</a>

                               @if(in_array($spk->status, ['draft', 'ditolak']))
                                    <button type="button"
        onclick="bukaModalEditSPK(this)"
        data-id="{{ $spk->id }}"
        data-catatan="{{ $spk->catatan_dosen }}"
        data-tahun="{{ $spk->tahun }}"
        data-rpk="{{ $spk->rpk_id }}"
        data-kegiatan="{{ $spk->kegiatan_id }}"
        data-tanggal="{{ $spk->tanggal_kegiatan }}"
        data-penyelenggara="{{ $spk->penyelenggara }}"
        data-kategori="{{ $spk->kategori }}"
        data-url="{{ $spk->url_kegiatan }}"
        data-bukti="{{ $spk->bukti ? asset('storage/'.$spk->bukti) : '' }}"
        data-keterangan="{{ $spk->keterangan }}"
        class="bg-yellow-500 hover:bg-yellow-400 text-white px-4 py-2 rounded-lg text-sm transition">
    Edit
</button>
                                @endif

                                @if(in_array($spk->status, ['draft', 'ditolak']))
                                    <form action="{{ route('spks.destroy', $spk->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="hapusSpk(this)"
                                                class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg">
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                                @if($spk->status == 'disetujui')
                                    <span class="text-gray-400">-</span>
                                @endif

                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center py-10 text-gray-400">
                            Belum ada data SPK
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
// --- Script Hapus SPK ---
function hapusSpk(button) {
    Swal.fire({
        title: 'Hapus SPK?',
        text: 'Data yang dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if(result.isConfirmed){
            button.closest('form').submit();
        }
    });
}

// --- Variabel Data Kegiatan untuk Modal ---
const kegiatanData = @json($kegiatans ?? []);

// --- Script Tambah SPK (Modal Dinamis + Upload File) ---
function bukaModalTambahSPK() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah SPK</h2>',
        width: '600px',
        html: `
            <form id="formTambahSPK" action="{{ route('spks.store') }}" method="POST" enctype="multipart/form-data" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun *</label>
                    <select name="tahun" id="swal_tahun" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                        @for($i = date('Y'); $i >= date('Y') - 8; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">RPK *</label>
                    <select name="rpk_id" id="swal_rpk_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                        <option value="">Pilih RPK</option>
                        @foreach($rpks ?? [] as $rpk)
                            <option value="{{ $rpk->id }}">{{ $rpk->tahun }} - {{ $rpk->semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kegiatan *</label>
                    <select name="kegiatan_id" id="swal_kegiatan_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                        <option value="">Pilih RPK terlebih dahulu</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kegiatan *</label>
                    <input type="date" name="tanggal_kegiatan" id="swal_tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Penyelenggara *</label>
                    <input type="text" name="penyelenggara" id="swal_penyelenggara" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori *</label>
                    <select name="kategori" id="swal_kategori" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                        <option value="Individu">Individu</option>
                        <option value="Kelompok">Kelompok</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">URL Kegiatan</label>
                    <input type="url" name="url_kegiatan" id="swal_url" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bukti (PDF max 5MB) *</label>
                    <input type="file" name="bukti" id="swal_bukti" accept=".pdf" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan *</label>
                    <textarea name="keterangan" id="swal_keterangan" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required></textarea>
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
            const rpkSelect = document.getElementById('swal_rpk_id');
            const kegiatanSelect = document.getElementById('swal_kegiatan_id');

            rpkSelect.addEventListener('change', function() {
                let rpkId = this.value;
                kegiatanSelect.innerHTML = '<option value="">Pilih Kegiatan</option>';

                kegiatanData.forEach(function(kegiatan) {
                    if (kegiatan.rpk_id == rpkId) {
                        kegiatanSelect.innerHTML += `<option value="${kegiatan.id}">${kegiatan.kegiatan}</option>`;
                    }
                });
            });
        },
        preConfirm: () => {
            const rpk = document.getElementById('swal_rpk_id').value;
            const kegiatan = document.getElementById('swal_kegiatan_id').value;
            const tanggal = document.getElementById('swal_tanggal').value;
            const penyelenggara = document.getElementById('swal_penyelenggara').value;
            const bukti = document.getElementById('swal_bukti').value;
            const keterangan = document.getElementById('swal_keterangan').value;

            if (!rpk || !kegiatan || !tanggal || !penyelenggara || !bukti || !keterangan) {
                Swal.showValidationMessage('Harap lengkapi semua field wajib (bertanda *)');
                return false;
            }

            document.getElementById('formTambahSPK').submit();
        }
    });
}

// --- Script Edit SPK (Modal Dinamis + Upload File) ---
function bukaModalEditSPK(button) {
    // 1. Ambil semua data dari atribut tombol
    const id = button.getAttribute('data-id');
    const catatan = button.getAttribute('data-catatan');
    const tahun = button.getAttribute('data-tahun');
    const rpkId = button.getAttribute('data-rpk');
    const kegiatanId = button.getAttribute('data-kegiatan');
    const tanggal = button.getAttribute('data-tanggal');
    const penyelenggara = button.getAttribute('data-penyelenggara');
    const kategori = button.getAttribute('data-kategori');
    const url = button.getAttribute('data-url');
    const bukti = button.getAttribute('data-bukti');
    const keterangan = button.getAttribute('data-keterangan');

    // 2. Buat URL Action dinamis
    let actionUrl = "{{ route('spks.update', ':id') }}".replace(':id', id);

    // 3. Render blok Catatan Dosen (jika ada)
    let catatanHtml = '';
    if (catatan) {
        catatanHtml = `
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-4 text-sm text-left">
                <strong>Catatan Dosen:</strong><br>${catatan}
            </div>
        `;
    }

    // 4. Render Link File Bukti Lama (jika ada)
    let buktiHtml = '';
    if (bukti) {
        buktiHtml = `
            <div class="mb-2 text-sm text-left">
                <a href="${bukti}" target="_blank" class="text-blue-600 underline font-medium">Lihat Bukti Saat Ini</a>
            </div>
        `;
    }

    // 5. Tampilkan SweetAlert
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit SPK</h2>',
        width: '600px',
        html: `
            <form id="formEditSPK" action="${actionUrl}" method="POST" enctype="multipart/form-data" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">
                @csrf
                @method('PUT')

                ${catatanHtml}

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun *</label>
                    <select name="tahun" id="edit_swal_tahun" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
                        @for($i = date('Y'); $i >= date('Y') - 8; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">RPK *</label>
                    <select name="rpk_id" id="edit_swal_rpk_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
                        <option value="">Pilih RPK</option>
                        @foreach($rpks ?? [] as $rpk)
                            <option value="{{ $rpk->id }}">{{ $rpk->tahun }} - {{ $rpk->semester }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kegiatan *</label>
                    <select name="kegiatan_id" id="edit_swal_kegiatan_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
                        <option value="">Pilih RPK terlebih dahulu</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kegiatan *</label>
                    <input type="date" name="tanggal_kegiatan" id="edit_swal_tanggal" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Penyelenggara *</label>
                    <input type="text" name="penyelenggara" id="edit_swal_penyelenggara" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori *</label>
                    <select name="kategori" id="edit_swal_kategori" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required>
                        <option value="Individu">Individu</option>
                        <option value="Kelompok">Kelompok</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">URL Kegiatan</label>
                    <input type="url" name="url_kegiatan" id="edit_swal_url" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bukti (PDF max 5MB)</label>
                    ${buktiHtml}
                    <input type="file" name="bukti" accept=".pdf" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200">
                    <small class="text-gray-500 mt-1 block">Kosongkan jika tidak ingin mengganti file.</small>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan *</label>
                    <textarea name="keterangan" id="edit_swal_keterangan" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring focus:ring-blue-200" required></textarea>
                </div>

            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Simpan Perubahan',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB',
        cancelButtonColor: '#9CA3AF',
        customClass: { popup: 'rounded-2xl p-4' },
        didOpen: () => {
            // 1. Ambil elemen DOM Edit
            const elTahun = document.getElementById('edit_swal_tahun');
            const elRpk = document.getElementById('edit_swal_rpk_id');
            const elKegiatan = document.getElementById('edit_swal_kegiatan_id');
            const elTanggal = document.getElementById('edit_swal_tanggal');
            const elPenyelenggara = document.getElementById('edit_swal_penyelenggara');
            const elKategori = document.getElementById('edit_swal_kategori');
            const elUrl = document.getElementById('edit_swal_url');
            const elKeterangan = document.getElementById('edit_swal_keterangan');

            // 2. Isi data statis ke dalam input
            elTahun.value = tahun;
            elTanggal.value = tanggal;
            elPenyelenggara.value = penyelenggara;
            elKategori.value = kategori;
            elUrl.value = url === 'null' ? '' : url;
            elKeterangan.value = keterangan;
            
            // 3. Logika untuk mengisi RPK dan memicu update daftar Kegiatan
            elRpk.value = rpkId;
            
            // Fungsi untuk memuat dropdown Kegiatan
            const muatKegiatan = (idRpkTerpilih, idKegiatanTerpilih = null) => {
                elKegiatan.innerHTML = '<option value="">Pilih Kegiatan</option>';
                kegiatanData.forEach(function(keg) {
                    if (keg.rpk_id == idRpkTerpilih) {
                        let selected = (idKegiatanTerpilih == keg.id) ? 'selected' : '';
                        elKegiatan.innerHTML += `<option value="${keg.id}" ${selected}>${keg.kegiatan}</option>`;
                    }
                });
            };

            // Panggil muat kegiatan saat pertama kali dibuka (Pre-fill)
            muatKegiatan(rpkId, kegiatanId);

            // Pasang event listener jika user mengubah RPK lagi saat mengedit
            elRpk.addEventListener('change', function() {
                muatKegiatan(this.value);
            });
        },
        preConfirm: () => {
            // Validasi manual wajib isi
            const reqRpk = document.getElementById('edit_swal_rpk_id').value;
            const reqKeg = document.getElementById('edit_swal_kegiatan_id').value;
            const reqTgl = document.getElementById('edit_swal_tanggal').value;
            const reqPny = document.getElementById('edit_swal_penyelenggara').value;
            const reqKet = document.getElementById('edit_swal_keterangan').value;

            if (!reqRpk || !reqKeg || !reqTgl || !reqPny || !reqKet) {
                Swal.showValidationMessage('Harap lengkapi field wajib (Tahun, RPK, Kegiatan, Tanggal, Penyelenggara, Keterangan)');
                return false;
            }

            // Submit native form (menangani file upload PUT method)
            document.getElementById('formEditSPK').submit();
        }
    });
}

</script>

</x-app-layout>