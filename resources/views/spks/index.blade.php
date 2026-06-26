<x-app-layout>

<div class="py-6">

   <div class="max-w-8xl mx-auto py-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">SPK</h1>
                <p class="text-gray-500">Satuan Prestasi Kemahasiswaan</p>
            </div>

            {{-- 🔧 Tombol hanya untuk ketua (bukan anggota only) --}}
            @php
                $isAnggotaOnly = !\App\Models\Rpk::where('user_id', Auth::id())->exists() && 
                                 \App\Models\Kegiatan::whereHas('anggota', function($q) { 
                                     $q->where('user_id', Auth::id()); 
                                 })->exists();
            @endphp

            {{-- ✅ Semua mahasiswa bisa tambah SPK --}}
                <button onclick="bukaModalTambahSPK()"
                class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg text-sm font-semibold transition cursor-pointer">
                    + Tambah SPK
                </button>
        </div>

        {{-- Filter --}}
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <form method="GET" action="{{ route('spks.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="w-full md:w-64">
                    <label class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Tahun</label>
                    <select name="tahun" class="w-full border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Tahun</option>
                        @php $tahunSekarang = date('Y'); $tahunAwal = 2020; @endphp
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
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2 rounded-lg text-sm font-semibold transition w-full md:w-auto whitespace-nowrap">Terapkan Filter</button>
                    @if(request('tahun') || request('status'))
                        <a href="{{ route('spks.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm font-semibold transition text-center whitespace-nowrap">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel SPK --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-center w-16">No</th>
                        @if($isAnggotaOnly)<th class="px-6 py-4">Ketua</th>@endif
                        <th class="px-6 py-4">Tahun</th>
                        <th class="px-6 py-4">RPK</th>
                        <th class="px-6 py-4">Judul Kegiatan</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Hasil</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($spks as $spk)
                    <tr class="hover:bg-blue-50 transition duration-200 @if($isAnggotaOnly && $spk->user_id != Auth::id()) bg-yellow-50/30 @endif">
                        <td class="px-6 py-4 text-center font-medium text-gray-900">{{ $loop->iteration }}</td>
                        
                        @if($isAnggotaOnly)
                        <td class="px-6 py-4">
                            <span class="font-medium text-gray-800">{{ $spk->user->name ?? '-' }}</span>
                        </td>
                        @endif

                        <td class="px-6 py-4 font-semibold text-gray-800">{{ $spk->tahun }}</td>
                        <td class="px-6 py-4">{{ $spk->rpk->tahun ?? '-' }} - {{ $spk->rpk->semester ?? '-' }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">
                            {{ $spk->judul_kegiatan ?? $spk->kegiatan->judul_kegiatan ?? $spk->kegiatan->kegiatan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $spk->kegiatan->kegiatan ?? '-' }}</td>
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $spk->kategori ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $spk->hasil ?? '-' }}</td>
                        <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $spk->poin ?? '0' }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($spk->status == 'draft')
                                <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
                            @elseif($spk->status == 'diajukan')
                                <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Diajukan</span>
                            @elseif($spk->status == 'disetujui')
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Disetujui</span>
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('spks.show', $spk->id) }}" title="Detail SPK"
                                   class="flex items-center justify-center w-9 h-9 bg-gray-400 text-white hover:bg-gray-500 rounded-lg transition shadow-sm">
                                    <i class="fas fa-eye"></i>
                                </a>

                                {{-- 🔧 Edit/Hapus hanya untuk pemilik & bukan anggota only --}}
                                @if(!$isAnggotaOnly && $spk->user_id == Auth::id() && in_array($spk->status, ['draft', 'ditolak']))
                                    <button type="button" onclick="bukaModalEditSPK(this)"
                                            data-id="{{ $spk->id }}"
                                            data-catatan="{{ e($spk->catatan_dosen) }}"
                                            data-tahun="{{ $spk->tahun }}"
                                            data-rpk="{{ $spk->rpk_id }}"
                                            data-kegiatan="{{ $spk->kegiatan_id }}"
                                            data-tanggal="{{ $spk->tanggal_kegiatan }}"
                                            data-penyelenggara="{{ e($spk->penyelenggara) }}"
                                            data-kategori="{{ $spk->kategori }}"
                                            data-prestasi="{{ $spk->prestasi_id }}"
                                            data-poin="{{ $spk->poin }}"
                                            data-tingkat="{{ $spk->tingkat }}"  {{-- 🔧 TAMBAH --}}
                                            data-url="{{ $spk->url_kegiatan }}"
                                            data-bukti="{{ $spk->bukti ? asset('storage/'.$spk->bukti) : '' }}"
                                            data-keterangan="{{ e($spk->keterangan) }}"
                                            title="Edit SPK"
                                            class="flex items-center justify-center w-9 h-9 bg-yellow-500 text-white hover:bg-yellow-600 rounded-lg transition shadow-sm">
                                        <i class="fas fa-pen"></i>
                                    </button>

                                    <form action="{{ route('spks.destroy', $spk->id) }}" method="POST" class="m-0">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="hapusSpk(this)" title="Hapus SPK"
                                                class="flex items-center justify-center w-9 h-9 bg-red-500 text-white hover:bg-red-600 rounded-lg transition shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $isAnggotaOnly ? '11' : '10' }}" class="text-center py-12 text-gray-400 font-medium">
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
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });</script>
@endif

@if($errors->any())
<script>Swal.fire({ icon: 'error', title: 'Gagal!', html: `<ul style="text-align:left">@foreach($errors->all() as $e)<li>- {{ $e }}</li>@endforeach</ul>` });</script>
@endif

{{-- 🔧 SCRIPT FORM MODAL (HANYA UNTUK KETUA) --}}
@if(!$isAnggotaOnly)
<script>
const kegiatanData = @json($kegiatans ?? []);
const prestasiData = @json($prestasis ?? []);

function hapusSpk(button) {
    Swal.fire({
        title: 'Hapus SPK?', text: 'Data tidak dapat dikembalikan.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal'
    }).then(r => { if(r.isConfirmed) button.closest('form').submit(); });
}

function generateFormHTML(prefix) {
    return `
        <div class="mb-4"><label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Pengajuan *</label>
            <select name="tahun" id="${prefix}_tahun" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required>
                @for($i = date('Y'); $i >= date('Y') - 8; $i--)<option value="{{ $i }}">{{ $i }}</option>@endfor
            </select></div>
        <div class="mb-4"><label class="block text-sm font-semibold text-gray-700 mb-2">RPK (Disetujui) *</label>
            <select name="rpk_id" id="${prefix}_rpk" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">Pilih RPK</option>
                @foreach($rpksDisetujui ?? $rpks ?? [] as $rpk)
                    <option value="{{ $rpk->id }}">{{ $rpk->tahun }} - {{ $rpk->semester }} ({{ $rpk->user->name ?? '' }})</option>
                @endforeach
            </select></div>
        <div class="mb-4"><label class="block text-sm font-semibold text-gray-700 mb-2">Kegiatan *</label>
            <select name="kegiatan_id" id="${prefix}_kegiatan" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">Pilih RPK terlebih dahulu</option>
            </select></div>
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal (Otomatis)</label>
                <input type="date" name="tanggal_kegiatan" id="${prefix}_tanggal" class="w-full bg-gray-50 border border-gray-300 text-gray-700 rounded-lg p-2 outline-none" readonly required></div>
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Kategori (Otomatis)</label>
                <input type="text" id="${prefix}_kategori_display" class="w-full bg-gray-50 border border-gray-300 text-gray-700 rounded-lg p-2 outline-none" readonly>
                <input type="hidden" name="kategori" id="${prefix}_kategori"></div>
        </div>

        {{-- HASIL, TINGKAT & POIN - SEIMBANG --}}
<div class="grid grid-cols-12 gap-3 mb-4">
    <div class="col-span-4"><label class="block text-sm font-semibold text-gray-700 mb-2">Hasil / Prestasi *</label>
        <select name="prestasi_id" id="${prefix}_prestasi" class="w-full border border-gray-300 rounded-lg px-3 py-3 outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
            <option value="" data-poin="0" data-tingkat="">-- Pilih --</option>
            @foreach($prestasis as $prestasi)
                <option value="{{ $prestasi->id }}" data-poin="{{ $prestasi->poin }}" data-tingkat="{{ $prestasi->tingkat }}">{{ $prestasi->juara }}</option>
            @endforeach
        </select></div>
    <div class="col-span-4"><label class="block text-sm font-semibold text-gray-700 mb-2">Tingkat</label>
        <input type="text" id="${prefix}_tingkat_display"  class="w-full border border-gray-300 rounded-lg px-3 py-3 outline-none focus:ring-2 focus:ring-blue-500 text-sm" readonly>
        <input type="hidden" name="tingkat" id="${prefix}_tingkat" value=""></div>
    <div class="col-span-4"><label class="block text-sm font-semibold text-gray-700 mb-2">Poin</label>
        <input type="text" id="${prefix}_poin_display" class="w-full border border-gray-300 rounded-lg px-3 py-3 outline-none focus:ring-2 focus:ring-blue-500 text-sm" readonly>
        <input type="hidden" name="poin" id="${prefix}_poin" value="0"></div>
</div>

        <div class="mb-4"><label class="block text-sm font-semibold text-gray-700 mb-2">Penyelenggara *</label>
            <input type="text" name="penyelenggara" id="${prefix}_penyelenggara" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required></div>
        <div class="mb-4"><label class="block text-sm font-semibold text-gray-700 mb-2">URL Kegiatan (Opsional)</label>
            <input type="url" name="url_kegiatan" id="${prefix}_url" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500"></div>
        <div class="mb-4"><label class="block text-sm font-semibold text-gray-700 mb-2">Bukti (PDF max 5MB) *</label>
            <input type="file" name="bukti" id="${prefix}_bukti" accept=".pdf" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" ${prefix === 'add' ? 'required' : ''}>
            ${prefix === 'edit' ? '<small class="text-gray-500 mt-1 block">Kosongkan jika tidak ingin mengubah file.</small>' : ''}</div>
        <div class="mb-4"><label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan *</label>
            <textarea name="keterangan" id="${prefix}_keterangan" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required></textarea></div>
    `;
}

function bindLogikaForm(prefix) {
    const elRpk = document.getElementById(`${prefix}_rpk`);
    const elKegiatan = document.getElementById(`${prefix}_kegiatan`);
    const elTanggal = document.getElementById(`${prefix}_tanggal`);
    const elKategoriDisplay = document.getElementById(`${prefix}_kategori_display`);
    const elKategori = document.getElementById(`${prefix}_kategori`);
    const elPrestasi = document.getElementById(`${prefix}_prestasi`);
    const elPoinDisplay = document.getElementById(`${prefix}_poin_display`);
    const elPoin = document.getElementById(`${prefix}_poin`);
    const elTingkatDisplay = document.getElementById(`${prefix}_tingkat_display`); // 🔧 TAMBAH
    const elTingkat = document.getElementById(`${prefix}_tingkat`); // 🔧 TAMBAH

    if(elRpk) elRpk.onchange = function() {
        elKegiatan.innerHTML = '<option value="">Pilih Kegiatan</option>';
        elTanggal.value = ''; elKategoriDisplay.value = ''; elKategori.value = '';
        kegiatanData.forEach(k => {
            if(k.rpk_id == this.value && k.rpk?.status === 'disetujui')
                elKegiatan.innerHTML += `<option value="${k.id}" data-tanggal="${k.tanggal||''}" data-kategori="${k.kategori||''}">${k.judul_kegiatan||k.kegiatan}</option>`;
        });
    };
    if(elKegiatan) elKegiatan.onchange = function() {
        const opt = this.options[this.selectedIndex];
        elTanggal.value = opt.dataset.tanggal || '';
        elKategoriDisplay.value = opt.dataset.kategori || '';
        elKategori.value = opt.dataset.kategori || '';
    };
    if(elPrestasi) elPrestasi.onchange = function() {
        const opt = this.options[this.selectedIndex];
        elPoinDisplay.value = opt.dataset.poin || '0';
        elPoin.value = opt.dataset.poin || '0';
        // 🔧 AUTO-FILL TINGKAT
        elTingkatDisplay.value = opt.dataset.tingkat || '';
        elTingkat.value = opt.dataset.tingkat || '';
    };
}

function validasiForm(prefix) {
    const rpk = document.getElementById(`${prefix}_rpk`).value;
    const kegiatan = document.getElementById(`${prefix}_kegiatan`).value;
    const prestasi = document.getElementById(`${prefix}_prestasi`).value;
    const penyelenggara = document.getElementById(`${prefix}_penyelenggara`).value;
    const keterangan = document.getElementById(`${prefix}_keterangan`).value;
    const bukti = document.getElementById(`${prefix}_bukti`).value;
    if(!rpk||!kegiatan||!prestasi||!penyelenggara||!keterangan) { Swal.showValidationMessage('Harap lengkapi semua field wajib!'); return false; }
    if(prefix==='add'&&!bukti) { Swal.showValidationMessage('Harap upload file bukti!'); return false; }
    return true;
}

function bukaModalTambahSPK() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah SPK</h2>', width: '650px',
        html: `<form id="formAdd" action="{{ route('spks.store') }}" method="POST" enctype="multipart/form-data" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">@csrf ${generateFormHTML('add')}</form>`,
        showCancelButton: true, confirmButtonText: 'Simpan', cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF', allowOutsideClick: false, allowEscapeKey: false,
        customClass: { popup: 'rounded-2xl p-6' }, didOpen: () => bindLogikaForm('add'),
        preConfirm: () => { if(validasiForm('add')) { Swal.showLoading(); document.getElementById('formAdd').submit(); return false; } return false; }
    });
}

function bukaModalEditSPK(button) {
    const id = button.getAttribute('data-id'), catatan = button.getAttribute('data-catatan'), tahun = button.getAttribute('data-tahun');
    const rpkId = button.getAttribute('data-rpk'), kegiatanId = button.getAttribute('data-kegiatan');
    const tanggal = button.getAttribute('data-tanggal'), penyelenggara = button.getAttribute('data-penyelenggara');
    const kategori = button.getAttribute('data-kategori'), url = button.getAttribute('data-url');
    const bukti = button.getAttribute('data-bukti'), keterangan = button.getAttribute('data-keterangan');
    const prestasiId = button.getAttribute('data-prestasi'), poin = button.getAttribute('data-poin');
    const tingkat = button.getAttribute('data-tingkat'); // 🔧 TAMBAH
    let actionUrl = "{{ route('spks.update', ':id') }}".replace(':id', id);
    let catatanHtml = (catatan && catatan!=='null') ? `<div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-4 text-sm"><strong>Catatan Dosen:</strong><br>${catatan}</div>` : '';
    let buktiHtml = bukti ? `<div class="mb-2 text-sm"><a href="${bukti}" target="_blank" class="text-blue-600 underline"><i class="fas fa-file-pdf"></i> Lihat Bukti Saat Ini</a></div>` : '';

    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit SPK</h2>', width: '650px',
        html: `<form id="formEdit" action="${actionUrl}" method="POST" enctype="multipart/form-data" class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">@csrf @method('PUT') ${catatanHtml} ${generateFormHTML('edit')}</form>`,
        showCancelButton: true, confirmButtonText: 'Update', cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF', allowOutsideClick: false, allowEscapeKey: false,
        customClass: { popup: 'rounded-2xl p-6' },
        didOpen: () => {
            bindLogikaForm('edit');
            document.getElementById('edit_tahun').value = tahun;
            document.getElementById('edit_rpk').value = rpkId;
            document.getElementById('edit_rpk').dispatchEvent(new Event('change'));
            setTimeout(() => {
                document.getElementById('edit_kegiatan').value = kegiatanId;
                document.getElementById('edit_kegiatan').dispatchEvent(new Event('change'));
                document.getElementById('edit_penyelenggara').value = penyelenggara;
                document.getElementById('edit_url').value = (url==='null')?'':url;
                document.getElementById('edit_keterangan').value = keterangan;
                if(prestasiId) { 
                    document.getElementById('edit_prestasi').value = prestasiId; 
                    document.getElementById('edit_prestasi').dispatchEvent(new Event('change')); 
                }
                if(buktiHtml) document.getElementById('edit_bukti').insertAdjacentHTML('beforebegin', buktiHtml);
            }, 300);
        },
        preConfirm: () => { if(validasiForm('edit')) { Swal.showLoading(); document.getElementById('formEdit').submit(); return false; } return false; }
    });
}
</script>
@endif

</x-app-layout>