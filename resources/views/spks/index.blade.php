<x-app-layout>

<div class="py-6">

   <div class="max-w-8xl mx-auto py-6">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    SPK
                </h1>
                <p class="text-gray-500">
                    Satuan Prestasi Kemahasiswaan
                </p>
            </div>

            <button onclick="bukaModalTambahSPK()"
               class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg text-sm font-semibold transition cursor-pointer">
                + Tambah SPK
            </button>

        </div>

        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('spks.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                
                <div class="w-full md:w-64">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Tahun</label>
                    <select name="tahun" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Tahun</option>
                        @php
                            $tahunSekarang = date('Y');
                            $tahunAwal = 2020; // Sesuaikan dengan awal sistem Anda
                        @endphp
                        @for($i = $tahunSekarang; $i >= $tahunAwal; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="w-full md:w-64">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full md:w-auto">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg text-sm font-semibold transition w-full md:w-auto whitespace-nowrap">
                        Terapkan Filter
                    </button>
                    @if(request('tahun') || request('status'))
                        <a href="{{ route('spks.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition text-center whitespace-nowrap">
                            Reset
                        </a>
                    @endif
                </div>

            </form>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-center w-16">No</th>
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">RPK</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Jenis</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4">Catatan Dosen</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($spks as $spk)

                    <tr class="hover:bg-blue-50 transition duration-200">

                        <td class="px-6 py-4 text-center font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-semibold text-gray-800">
                            {{ $spk->tahun }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->rpk->tahun ?? '-' }} - {{ $spk->rpk->semester ?? '-' }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $spk->kegiatan->kegiatan ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->kegiatan->jenis ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($spk->status == 'draft')
                                <span class="bg-orange-500 text-white border border-orange-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    Draft
                                </span>
                            @elseif($spk->status == 'disetujui')
                                <span class="bg-green-500 text-white border border-green-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    Disetujui
                                </span>
                            @else
                                <span class="bg-red-500 text-white border border-red-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    Ditolak
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-gray-500 italic">
                            {{ $spk->catatan_dosen ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                               <a href="{{ route('spks.show', $spk->id) }}"
                                  class="bg-blue-500 text-white hover:bg-blue-600 hover:text-white border border-blue-200 px-3 py-1.5 rounded-lg text-sm font-semibold transition">
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
                                            class="bg-yellow-500 text-white hover:bg-yellow-600 hover:text-white border border-yellow-200 px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                                        Edit
                                    </button>
                                @endif

                                @if(in_array($spk->status, ['draft', 'ditolak']))
                                    <form action="{{ route('spks.destroy', $spk->id) }}" method="POST" class="delete-form inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                onclick="hapusSpk(this)"
                                                class="bg-red-500 text-white hover:bg-red-600 hover:text-white border border-red-200 px-3 py-1.5 rounded-lg text-sm font-semibold transition">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="8" class="text-center py-12 text-gray-400 font-medium">
                            <i class="fas fa-folder-open text-3xl mb-3 text-gray-300 block"></i>
                            Belum ada data SPK yang ditemukan.
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session("success") }}',
    timer: 2500,
    showConfirmButton: false,
    toast: true,
    position: 'top-end'
});
</script>
@endif

@if($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Menyimpan!',
        html: `
            <ul style="text-align: left; color: #dc2626; font-size: 14px;">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        `,
    });
</script>
@endif

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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Pengajuan *</label>
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pelaksanaan *</label>
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">URL Kegiatan (Opsional)</label>
                    <input type="url" name="url_kegiatan" id="swal_url" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Bukti (PDF max 5MB) *</label>
                    <input type="file" name="bukti" id="swal_bukti" accept=".pdf" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan / Deskripsi Prestasi *</label>
                    <textarea name="keterangan" id="swal_keterangan" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring focus:ring-blue-200 outline-none" required></textarea>
                </div>

            </form>
        `,
        showCancelButton: true,
        confirmButtonText: 'Simpan Data',
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
    if (catatan && catatan !== 'null') {
        catatanHtml = `
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-4 text-sm text-left">
                <strong>Catatan Dosen Pembimbing:</strong><br>${catatan}
            </div>
        `;
    }

    // 4. Render Link File Bukti Lama (jika ada)
    let buktiHtml = '';
    if (bukti) {
        buktiHtml = `
            <div class="mb-2 text-sm text-left">
                <a href="${bukti}" target="_blank" class="text-blue-600 underline font-medium hover:text-blue-800 transition"><i class="fas fa-file-pdf"></i> Lihat File Bukti Saat Ini</a>
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
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pelaksanaan *</label>
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
                    <small class="text-gray-500 mt-1 block">Abaikan kolom file ini jika tidak ingin mengubah dokumen bukti yang sudah ada.</small>
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