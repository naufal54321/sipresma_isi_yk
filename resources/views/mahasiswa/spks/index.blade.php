<x-app-layout>

<div class="py-6">

   <div class="max-w-8xl mx-auto py-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">SPK</h1>
                <p class="text-gray-500">Satuan Prestasi Kemahasiswaan</p>
            </div>

            @php
                $isAnggotaOnly = !\App\Models\Rpk::where('user_id', Auth::id())->exists() && 
                                 \App\Models\Kegiatan::whereHas('anggota', function($q) { 
                                     $q->where('user_id', Auth::id()); 
                                 })->exists();
            @endphp

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
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition w-full md:w-auto whitespace-nowrap">Terapkan Filter</button>
                    @if(request('tahun') || request('status'))
                        <a href="{{ route('spks.index') }}" class="bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition text-center whitespace-nowrap">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Tabel SPK --}}
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b border-gray-200">
                        <tr>
                            <th class="px-2 py-3 text-center">No</th>
                            @if($isAnggotaOnly)<th class="px-6 py-4">Ketua</th>@endif
                            <th class="px-6 py-4">Tahun</th>
                            <th class="px-6 py-4">RPK</th>
                            <th class="px-6 py-4">Judul Kegiatan</th>
                            <th class="px-6 py-4">Kategori</th>
                            <th class="px-6 py-4">Tanggal Kegiatan</th>
                            <th class="px-6 py-4">Hasil</th>
                            <th class="px-6 py-4 text-center">Poin</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody" class="divide-y divide-gray-100">
                        @forelse($spks as $spk)
                        <tr data-spk-id="{{ $spk->id }}" class="hover:bg-blue-50 transition duration-200 @if($isAnggotaOnly && $spk->user_id != Auth::id()) bg-yellow-50/30 @endif">
                            <td class="px-6 py-4 text-center font-medium text-gray-900">{{ $loop->iteration }}</td>
                            
                            @if($isAnggotaOnly)
                            <td class="px-6 py-4"><span class="font-medium text-gray-800">{{ $spk->user->name ?? '-' }}</span></td>
                            @endif

                            <td class="px-6 py-4 font-semibold text-gray-800">{{ $spk->tahun }}</td>
                            <td class="px-6 py-4">{{ $spk->rpk->tahun ?? '-' }} - {{ $spk->rpk->semester ?? '-' }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $spk->judul_kegiatan ?? $spk->kegiatan->judul_kegiatan ?? $spk->kegiatan->kegiatan ?? '-' }}</td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ $spk->kategori ?? '-' }}</td>
                            <td class="px-6 py-4">
                                @if($spk->kegiatan && $spk->kegiatan->tanggal_mulai && $spk->kegiatan->tanggal_selesai)
                                    @php
                                        $tglMulai = \Carbon\Carbon::parse($spk->kegiatan->tanggal_mulai);
                                        $tglSelesai = \Carbon\Carbon::parse($spk->kegiatan->tanggal_selesai);
                                    @endphp
                                    @if($tglMulai->format('Y-m-d') === $tglSelesai->format('Y-m-d'))
                                        <span class="text-gray-800">{{ $tglMulai->translatedFormat('d M Y') }}</span>
                                    @else
                                        <span class="text-gray-800">{{ $tglMulai->translatedFormat('d M Y') }}</span>
                                        <span class="text-gray-400 mx-1">-</span>
                                        <span class="text-gray-800">{{ $tglSelesai->translatedFormat('d M Y') }}</span>
                                    @endif
                                @elseif($spk->kegiatan && $spk->kegiatan->tanggal_mulai)
                                    <span class="text-gray-800">{{ \Carbon\Carbon::parse($spk->kegiatan->tanggal_mulai)->translatedFormat('d M Y') }}</span>
                                @else
                                    {{-- ⚡ TIDAK PERLU PARSE LAGI, langsung tampilkan string --}}
                                    <span class="text-gray-800">{{ $spk->tanggal_kegiatan ?? '-' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">{{ $spk->hasil ?? '-' }}</td>
                            <td class="px-6 py-4 text-center font-bold text-blue-600">{{ $spk->poin ?? '0' }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($spk->status == 'draft')
                                    <span class="bg-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold">Draft</span>
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

                                    @if(!$isAnggotaOnly && $spk->user_id == Auth::id() && in_array($spk->status, ['draft', 'ditolak']))
                                        <button type="button" onclick="bukaModalEditSPK(this)"
                                                data-id="{{ $spk->id }}"
                                                data-tahun="{{ $spk->tahun }}"
                                                data-rpk="{{ $spk->rpk_id }}"
                                                data-kegiatan="{{ $spk->kegiatan_id }}"
                                                data-tanggal="{{ $spk->tanggal_kegiatan }}"
                                                data-penyelenggara="{{ e($spk->penyelenggara) }}"
                                                data-kategori="{{ $spk->kategori }}"
                                                data-prestasi="{{ $spk->prestasi_id }}"
                                                data-poin="{{ $spk->poin }}"
                                                data-tingkat="{{ $spk->tingkat }}"
                                                data-url="{{ $spk->url_kegiatan }}"
                                                data-link-drive="{{ $spk->link_drive }}"
                                                data-judul-karya="{{ e($spk->judul_karya) }}"
                                                data-biografi="{{ e($spk->biografi) }}"
                                                data-rincian="{{ e($spk->rincian) }}"
                                                data-kebaruan="{{ e($spk->kebaruan) }}"
                                                data-surat-tugas="{{ $spk->surat_tugas ? asset('storage/'.$spk->surat_tugas) : '' }}"
                                                data-sertifikat="{{ $spk->sertifikat ? asset('storage/'.$spk->sertifikat) : '' }}"
                                                data-foto-penyerahan="{{ $spk->foto_penyerahan ? asset('storage/'.$spk->foto_penyerahan) : '' }}"
                                                data-laporan="{{ $spk->laporan ? asset('storage/'.$spk->laporan) : '' }}"
                                                data-catatan="{{ e($spk->catatan_dosen) }}"
                                                title="Edit SPK"
                                                class="flex items-center justify-center w-9 h-9 bg-yellow-500 text-white hover:bg-yellow-600 rounded-lg transition shadow-sm">
                                            <i class="fas fa-pen"></i>
                                        </button>

                                        <button type="button" onclick="hapusSPK({{ $spk->id }})" title="Hapus SPK"
                                                class="flex items-center justify-center w-9 h-9 bg-red-500 text-white hover:bg-red-600 rounded-lg transition shadow-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyRow">
                            <td colspan="{{ $isAnggotaOnly ? '13' : '12' }}" class="text-center py-12 text-gray-400 font-medium">
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
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>Swal.fire({ icon: 'success', title: 'Berhasil', text: '{{ session("success") }}', timer: 2500, showConfirmButton: false, toast: true, position: 'top-end' });</script>
@endif

@if($errors->any())
<script>Swal.fire({ icon: 'error', title: 'Gagal!', html: `<ul style="text-align:left">@foreach($errors->all() as $e)<li>- {{ $e }}</li>@endforeach</ul>` });</script>
@endif

{{-- SCRIPT --}}
@if(!$isAnggotaOnly)
<script>
const MAX_FILE_SIZE = 5 * 1024 * 1024;

// ⚡ VALIDASI UKURAN FILE
function validateFileSize(input, label) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        if (file.size > MAX_FILE_SIZE) {
            const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
            Swal.fire({
                icon: 'warning', title: 'File Terlalu Besar!',
                html: `<div class="text-left text-sm"><p><strong>File:</strong> ${label}</p><p><strong>Ukuran:</strong> ${fileSizeMB} MB</p><p><strong>Maksimal:</strong> 5 MB</p><hr class="my-2"><p class="text-red-500">Silakan pilih file lebih kecil.</p></div>`,
                confirmButtonColor: '#dc2626', confirmButtonText: 'Mengerti'
            });
            input.value = ''; return false;
        }
    }
    return true;
}

// ⚡ HAPUS SPK (FULL AJAX)
function hapusSPK(id) {
    Swal.fire({
        title: 'Hapus SPK?', text: 'Data tidak dapat dikembalikan.', icon: 'warning',
        showCancelButton: true, confirmButtonColor: '#dc2626', cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal'
    }).then(r => {
        if(r.isConfirmed) {
            Swal.fire({ title: 'Menghapus...', allowOutsideClick: false, showConfirmButton: false, didOpen: () => Swal.showLoading() });
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            formData.append('_token', '{{ csrf_token() }}');
            fetch(`/spks/${id}`, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.success) { Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'SPK berhasil dihapus', timer: 1500, showConfirmButton: false }).then(() => location.reload()); }
                else throw new Error(data.message || 'Gagal');
            })
            .catch(err => Swal.fire({ icon: 'error', title: 'Gagal!', text: err.message }));
        }
    });
}

// ⚡ PREVIEW FILE
function generateFilePreview(label, url) {
    if (url && url !== 'null' && url !== '') {
        const ext = url.split('.').pop().toLowerCase();
        const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext);
        let previewHtml = isImage ? `<img src="${url}" class="max-w-full max-h-[200px] rounded-lg object-contain mb-2 border">` : `<iframe src="${url}" class="w-full h-[200px] rounded-lg border mb-2"></iframe>`;
        return `<div class="mb-2 p-3 bg-gray-50 rounded-lg border"><div class="flex items-center justify-between mb-2"><span class="text-xs font-semibold text-gray-600">File Saat Ini: ${label}</span><a href="${url}" target="_blank" class="text-xs text-blue-600 hover:underline"><i class="fas fa-external-link-alt mr-1"></i>Buka</a></div>${previewHtml}</div>`;
    }
    return '';
}

// ⚡ GENERATE FORM HTML
function generateFormHTML(prefix) {
    const isAdd = prefix === 'add';
    const requiredAttr = isAdd ? 'required' : '';
    const requiredStar = isAdd ? ' <span class="text-red-500">*</span>' : '';
    
    return `
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Pengajuan <span class="text-red-500">*</span></label>
            <select name="tahun" id="${prefix}_tahun" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">Pilih Tahun</option>
                @for($i = date('Y') + 5; $i >= 2020; $i--)<option value="{{ $i }}">{{ $i }}</option>@endfor
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">RPK (Disetujui) <span class="text-red-500">*</span></label>
            <select name="rpk_id" id="${prefix}_rpk" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">Pilih RPK</option>
                @foreach($rpks ?? [] as $rpk)
                    <option value="{{ $rpk->id }}" data-kegiatan-id="{{ $rpk->kegiatans->first()->id ?? '' }}" data-kegiatan-nama="{{ $rpk->kegiatans->first()->judul_kegiatan ?? $rpk->kegiatans->first()->kegiatan ?? '' }}" data-kegiatan-tanggal-mulai="{{ $rpk->kegiatans->first()->tanggal_mulai ?? '' }}" data-kegiatan-tanggal-selesai="{{ $rpk->kegiatans->first()->tanggal_selesai ?? '' }}" data-kegiatan-kategori="{{ $rpk->kegiatans->first()->kategori ?? '' }}">{{ $rpk->tahun }} - {{ $rpk->semester }} ({{ $rpk->user->name ?? '' }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kegiatan (Otomatis)</label>
            <input type="text" id="${prefix}_kegiatan_display" class="w-full bg-gray-100 border border-gray-300 text-gray-700 rounded-lg px-4 py-3 outline-none" readonly placeholder="Otomatis terisi dari RPK">
            <input type="hidden" name="kegiatan_id" id="${prefix}_kegiatan">
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Kegiatan (Dari RPK)</label>
            <div id="${prefix}_tanggal_range_display" class="w-full bg-gray-100 border border-gray-300 text-gray-700 rounded-lg px-4 py-3 outline-none text-sm">-</div>
            <input type="hidden" name="tanggal_kegiatan" id="${prefix}_tanggal">
            <p class="text-xs text-gray-400 mt-1">Tanggal pelaksanaan sesuai RPK</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori (Otomatis)</label>
            <input type="text" id="${prefix}_kategori_display" class="w-full bg-gray-100 border border-gray-300 text-gray-700 rounded-lg px-4 py-3 outline-none" readonly>
            <input type="hidden" name="kategori" id="${prefix}_kategori">
        </div>
        <div class="grid grid-cols-2 gap-3 mb-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Hasil / Prestasi <span class="text-red-500">*</span></label>
                <select name="prestasi_id" id="${prefix}_prestasi" class="w-full border border-gray-300 rounded-lg px-3 py-3 outline-none focus:ring-2 focus:ring-blue-500 text-sm" required>
                    <option value="" data-tingkat="">-- Pilih --</option>
                    @foreach($prestasis as $prestasi)<option value="{{ $prestasi->id }}" data-tingkat="{{ $prestasi->tingkat }}">{{ $prestasi->juara }}</option>@endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tingkat</label>
                <input type="text" id="${prefix}_tingkat_display" class="w-full bg-gray-100 border border-gray-300 rounded-lg px-3 py-3 outline-none text-sm" readonly>
                <input type="hidden" name="tingkat" id="${prefix}_tingkat" value="">
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Penyelenggara <span class="text-red-500">*</span></label>
            <input type="text" name="penyelenggara" id="${prefix}_penyelenggara" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Karya/Inovasi/Riset/Prestasi <span class="text-red-500">*</span></label>
            <input type="text" name="judul_karya" id="${prefix}_judul_karya" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan judul karya" ${requiredAttr}>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Biografi/Latar Belakang Individu/Tim <span class="text-gray-400 text-xs">(Opsional)</span></label>
            <textarea name="biografi" id="${prefix}_biografi" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Ceritakan latar belakang individu atau tim"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Rincian Inovasi/Riset/Prestasi <span class="text-gray-400 text-xs">(Opsional)</span></label>
            <textarea name="rincian" id="${prefix}_rincian" rows="4" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Jelaskan rincian inovasi/riset/prestasi yang dicapai"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Kebaruan/Keunggulan <span class="text-gray-400 text-xs">(Opsional)</span></label>
            <textarea name="kebaruan" id="${prefix}_kebaruan" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500" placeholder="Jelaskan kebaruan atau keunggulan dari karya ini"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">URL Kegiatan${requiredStar}</label>
            <input type="url" name="url_kegiatan" id="${prefix}_url" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" placeholder="https://..." ${requiredAttr}>
            <p class="text-xs text-gray-400 mt-1">Contoh: https://example.com/kegiatan</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Link Google Drive${requiredStar}</label>
            <input type="url" name="link_drive" id="${prefix}_link_drive" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" placeholder="https://drive.google.com/..." ${requiredAttr}>
            <p class="text-xs text-gray-400 mt-1">Contoh: https://drive.google.com/drive/folders/...</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Surat Tugas${requiredStar}</label>
            <div id="${prefix}_surat_tugas_preview"></div>
            <input type="file" name="surat_tugas" id="${prefix}_surat_tugas" accept=".pdf" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" ${requiredAttr} onchange="validateFileSize(this, 'Surat Tugas')">
            <p class="text-xs text-gray-400 mt-1">Format: PDF | Maksimal: 5 MB</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Sertifikat / Foto Piala${requiredStar}</label>
            <div id="${prefix}_sertifikat_preview"></div>
            <input type="file" name="sertifikat" id="${prefix}_sertifikat" accept=".pdf,.jpg,.jpeg,.png" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" ${requiredAttr} onchange="validateFileSize(this, 'Sertifikat')">
            <p class="text-xs text-gray-400 mt-1">Format: PDF, JPG, JPEG, PNG | Maksimal: 5 MB</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Penyerahan${requiredStar}</label>
            <div id="${prefix}_foto_penyerahan_preview"></div>
            <input type="file" name="foto_penyerahan" id="${prefix}_foto_penyerahan" accept=".jpg,.jpeg,.png" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" ${requiredAttr} onchange="validateFileSize(this, 'Foto Penyerahan')">
            <p class="text-xs text-gray-400 mt-1">Format: JPG, JPEG, PNG | Maksimal: 5 MB</p>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-semibold text-gray-700 mb-2">Laporan${requiredStar}</label>
            <div id="${prefix}_laporan_preview"></div>
            <input type="file" name="laporan" id="${prefix}_laporan" accept=".pdf" class="w-full border border-gray-300 rounded-lg px-4 py-3 outline-none" ${requiredAttr} onchange="validateFileSize(this, 'Laporan')">
            <p class="text-xs text-gray-400 mt-1">Format: PDF | Maksimal: 5 MB</p>
        </div>
    `;
}

// ⚡ BIND LOGIKA FORM
function bindLogikaForm(prefix) {
    const elRpk = document.getElementById(`${prefix}_rpk`);
    if (elRpk) {
        elRpk.onchange = function() {
            const opt = this.options[this.selectedIndex];
            document.getElementById(`${prefix}_kegiatan`).value = opt.dataset.kegiatanId || '';
            document.getElementById(`${prefix}_kegiatan_display`).value = opt.dataset.kegiatanNama || 'Tidak ada kegiatan';
            const tMulai = opt.dataset.kegiatanTanggalMulai || '', tSelesai = opt.dataset.kegiatanTanggalSelesai || '';
            const display = document.getElementById(`${prefix}_tanggal_range_display`);
            if (display) {
                if (tMulai && tSelesai) display.textContent = new Date(tMulai).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'}) + ' - ' + new Date(tSelesai).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'});
                else if (tMulai) display.textContent = new Date(tMulai).toLocaleDateString('id-ID',{day:'numeric',month:'long',year:'numeric'});
                else display.textContent = '-';
            }
            document.getElementById(`${prefix}_tanggal`).value = tMulai;
            document.getElementById(`${prefix}_kategori_display`).value = opt.dataset.kegiatanKategori || '-';
            document.getElementById(`${prefix}_kategori`).value = opt.dataset.kegiatanKategori || '';
        };
    }
    const elPrestasi = document.getElementById(`${prefix}_prestasi`);
    if (elPrestasi) elPrestasi.onchange = function() { const opt = this.options[this.selectedIndex]; document.getElementById(`${prefix}_tingkat_display`).value = opt.dataset.tingkat || ''; document.getElementById(`${prefix}_tingkat`).value = opt.dataset.tingkat || ''; };
}

// ⚡ TAMBAH SPK (FULL AJAX)
function bukaModalTambahSPK() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Tambah SPK</h2>', width: '700px',
        html: `<div class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">${generateFormHTML('add')}</div>`,
        showCancelButton: true, confirmButtonText: 'Simpan', cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF', allowOutsideClick: false,
        customClass: { popup: 'rounded-2xl p-6' }, didOpen: () => { bindLogikaForm('add'); },
        preConfirm: () => { 
            if (!validasiForm('add')) return false;
            Swal.showLoading();
            
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('tahun', document.getElementById('add_tahun').value);
            formData.append('rpk_id', document.getElementById('add_rpk').value);
            formData.append('kegiatan_id', document.getElementById('add_kegiatan').value);
            formData.append('tanggal_kegiatan', document.getElementById('add_tanggal').value);
            formData.append('penyelenggara', document.getElementById('add_penyelenggara').value);
            formData.append('kategori', document.getElementById('add_kategori').value);
            formData.append('prestasi_id', document.getElementById('add_prestasi').value);
            formData.append('tingkat', document.getElementById('add_tingkat').value);
            formData.append('judul_karya', document.getElementById('add_judul_karya').value);
            formData.append('biografi', document.getElementById('add_biografi')?.value || '');
            formData.append('rincian', document.getElementById('add_rincian')?.value || '');
            formData.append('kebaruan', document.getElementById('add_kebaruan')?.value || '');
            formData.append('url_kegiatan', document.getElementById('add_url').value);
            formData.append('link_drive', document.getElementById('add_link_drive').value);
            
            const suratTugas = document.getElementById('add_surat_tugas').files[0];
            const sertifikat = document.getElementById('add_sertifikat').files[0];
            const fotoPenyerahan = document.getElementById('add_foto_penyerahan').files[0];
            const laporan = document.getElementById('add_laporan').files[0];
            if (suratTugas) formData.append('surat_tugas', suratTugas);
            if (sertifikat) formData.append('sertifikat', sertifikat);
            if (fotoPenyerahan) formData.append('foto_penyerahan', fotoPenyerahan);
            if (laporan) formData.append('laporan', laporan);
            
            return fetch("{{ route('spks.store') }}", { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: formData })
            .then(res => res.json()).then(data => { if (data.success) return data; throw new Error(data.message); }).catch(err => { Swal.showValidationMessage(err.message); return false; });
        }
    }).then(r => { if (r.isConfirmed) { Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'SPK berhasil ditambahkan', timer: 1500, showConfirmButton: false }).then(() => location.reload()); } });
}

// ⚡ EDIT SPK (FULL AJAX)
function bukaModalEditSPK(button) {
    const id = button.getAttribute('data-id');
    let catatanHtml = button.getAttribute('data-catatan') && button.getAttribute('data-catatan') !== 'null' ? `<div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-4 text-sm"><strong>Catatan Dosen:</strong><br>${button.getAttribute('data-catatan')}</div>` : '';
    
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 text-left">Edit SPK</h2>', width: '700px',
        html: `<div class="text-left mt-4 max-h-[65vh] overflow-y-auto px-2">${catatanHtml} ${generateFormHTML('edit')}</div>`,
        showCancelButton: true, confirmButtonText: 'Update', cancelButtonText: 'Batal',
        confirmButtonColor: '#2563EB', cancelButtonColor: '#9CA3AF', allowOutsideClick: false,
        customClass: { popup: 'rounded-2xl p-6' },
        didOpen: () => {
            bindLogikaForm('edit');
            document.getElementById('edit_tahun').value = button.getAttribute('data-tahun') || '';
            document.getElementById('edit_rpk').value = button.getAttribute('data-rpk'); document.getElementById('edit_rpk').dispatchEvent(new Event('change'));
            ['surat_tugas','sertifikat','foto_penyerahan','laporan'].forEach(f => document.getElementById('edit_'+f+'_preview').innerHTML = generateFilePreview(f, button.getAttribute('data-'+f.replace(/_/g,'-'))));
            setTimeout(() => {
                document.getElementById('edit_penyelenggara').value = button.getAttribute('data-penyelenggara') || '';
                document.getElementById('edit_judul_karya').value = button.getAttribute('data-judul-karya') || '';
                document.getElementById('edit_biografi').value = button.getAttribute('data-biografi') || '';
                document.getElementById('edit_rincian').value = button.getAttribute('data-rincian') || '';
                document.getElementById('edit_kebaruan').value = button.getAttribute('data-kebaruan') || '';
                document.getElementById('edit_url').value = button.getAttribute('data-url') === 'null' ? '' : (button.getAttribute('data-url') || '');
                document.getElementById('edit_link_drive').value = button.getAttribute('data-link-drive') === 'null' ? '' : (button.getAttribute('data-link-drive') || '');
                const prestasiId = button.getAttribute('data-prestasi');
                if (prestasiId && prestasiId !== 'null') { const el = document.getElementById('edit_prestasi'); if (el) { el.value = prestasiId; el.dispatchEvent(new Event('change')); } }
            }, 200);
        },
        preConfirm: () => { 
            if (!validasiForm('edit')) return false;
            Swal.showLoading();
            
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}'); formData.append('_method', 'PUT');
            formData.append('tahun', document.getElementById('edit_tahun').value);
            formData.append('rpk_id', document.getElementById('edit_rpk').value);
            formData.append('kegiatan_id', document.getElementById('edit_kegiatan').value);
            formData.append('tanggal_kegiatan', document.getElementById('edit_tanggal').value);
            formData.append('penyelenggara', document.getElementById('edit_penyelenggara').value);
            formData.append('kategori', document.getElementById('edit_kategori').value);
            formData.append('prestasi_id', document.getElementById('edit_prestasi').value);
            formData.append('tingkat', document.getElementById('edit_tingkat').value);
            formData.append('judul_karya', document.getElementById('edit_judul_karya').value);
            formData.append('biografi', document.getElementById('edit_biografi')?.value || '');
            formData.append('rincian', document.getElementById('edit_rincian')?.value || '');
            formData.append('kebaruan', document.getElementById('edit_kebaruan')?.value || '');
            formData.append('url_kegiatan', document.getElementById('edit_url').value);
            formData.append('link_drive', document.getElementById('edit_link_drive').value);
            
            const suratTugas = document.getElementById('edit_surat_tugas').files[0];
            const sertifikat = document.getElementById('edit_sertifikat').files[0];
            const fotoPenyerahan = document.getElementById('edit_foto_penyerahan').files[0];
            const laporan = document.getElementById('edit_laporan').files[0];
            if (suratTugas) formData.append('surat_tugas', suratTugas);
            if (sertifikat) formData.append('sertifikat', sertifikat);
            if (fotoPenyerahan) formData.append('foto_penyerahan', fotoPenyerahan);
            if (laporan) formData.append('laporan', laporan);
            
            return fetch(`/spks/${id}`, { method: 'POST', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }, body: formData })
            .then(res => res.json()).then(data => { if (data.success) return data; throw new Error(data.message); }).catch(err => { Swal.showValidationMessage(err.message); return false; });
        }
    }).then(r => { if (r.isConfirmed) { Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'SPK berhasil diupdate', timer: 1500, showConfirmButton: false }).then(() => location.reload()); } });
}

// ⚡ VALIDASI FORM
function validasiForm(prefix) {
    const el = (id) => document.getElementById(`${prefix}_${id}`);
    
    if (!el('tahun')?.value) { Swal.showValidationMessage('Harap pilih Tahun Pengajuan!'); return false; }
    if (!el('rpk')?.value) { Swal.showValidationMessage('Harap pilih RPK!'); return false; }
    if (!el('kegiatan')?.value) { Swal.showValidationMessage('Kegiatan tidak tersedia!'); return false; }
    if (!el('prestasi')?.value) { Swal.showValidationMessage('Harap pilih Hasil / Prestasi!'); return false; }
    if (!el('penyelenggara')?.value) { Swal.showValidationMessage('Harap isi Penyelenggara!'); return false; }
    if (!el('judul_karya')?.value) { Swal.showValidationMessage('Harap isi Judul Karya!'); return false; }
    
    if (prefix === 'add') {
        if (!document.getElementById('add_surat_tugas')?.files[0]) { Swal.showValidationMessage('Harap upload Surat Tugas!'); return false; }
        if (!document.getElementById('add_sertifikat')?.files[0]) { Swal.showValidationMessage('Harap upload Sertifikat!'); return false; }
        if (!document.getElementById('add_foto_penyerahan')?.files[0]) { Swal.showValidationMessage('Harap upload Foto Penyerahan!'); return false; }
        if (!document.getElementById('add_laporan')?.files[0]) { Swal.showValidationMessage('Harap upload Laporan!'); return false; }
    }
    
    return true;
}
</script>
@endif

</x-app-layout>