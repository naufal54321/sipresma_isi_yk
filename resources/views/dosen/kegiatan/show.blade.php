<x-app-layout>
   
 <!-- Tombol Kembali -->
   <div class="col-span-2 mt-6">
        <a href="{{ route('dosen.kegiatan.index') }}"
           class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition">

            ← Kembali

        </a>
 @if($kegiatan->status == 'draft')
         <button onclick="approveKegiatan({{ $kegiatan->id }})"
            class="bg-green-500 hover:bg-green-500 text-white px-5 py-2 rounded-lg transition">
            Setujui
        </button>

        <button onclick="rejectKegiatan({{ $kegiatan->id }})"
            class="bg-red-500 hover:bg-red-500 text-white px-5 py-2 rounded-lg transition">
            Tolak
        </button>

     @else

        <span class="text-gray-400 font-medium">
            Selesai
        </span>

    @endif

    
</div>
    
<div class="max-w-8xl mx-auto py-6">

    <div class="bg-white shadow rounded-xl p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail Kegiatan RPK
        </h1>

        <div class="grid grid-cols-2 gap-5">

            <div>
                <strong>Mahasiswa</strong>
                <p>{{ $kegiatan->rpk->user->name }}</p>
            </div>

            <div>
                <strong>NIM</strong>
                <p>{{ $kegiatan->rpk->user->nim }}</p>
            </div>

            <div>
                <strong>Tahun RPK</strong>
                <p>{{ $kegiatan->rpk->tahun }}</p>
            </div>

            <div>
                <strong>Semester</strong>
                <p>{{ $kegiatan->rpk->semester }}</p>
            </div>

            <div class="col-span-2">
                <strong>Kegiatan</strong>
                <p>{{ $kegiatan->kegiatan }}</p>
            </div>

            <div>
                <strong>Jenis</strong>
                <p>{{ $kegiatan->jenis }}</p>
            </div>

            <div>
                <strong>Tingkat</strong>
                <p>{{ $kegiatan->tingkat }}</p>
            </div>

            <div>
                <strong>Hasil</strong>
                <p>{{ $kegiatan->hasil }}</p>
            </div>

            <div>
                <strong>Tanggal</strong>
                <p>{{ $kegiatan->tanggal }}</p>
            </div>

            <div>
                <strong>Peran</strong>
                <p>{{ $kegiatan->peran }}</p>
            </div>

            <div>
                <strong>Jumlah Anggota</strong>
                <p>{{ $kegiatan->jumlah_anggota ?? '-' }}</p>
            </div>

             <div>
                <strong>Poin</strong>
                <p> {{ $kegiatan->masterKegiatan->poin ?? '-' }}</p>
            </div>

            <div>
                <strong>Status</strong> <br>
               @if($kegiatan->status == 'draft')

                                <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs">
                                    Draft
                                </span>

                            @elseif($kegiatan->status == 'disetujui')

                                <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                                    Disetujui
                                </span>

                            @else

                                <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">
                                    Ditolak
                                </span>

                            @endif
            </div>

            <div>
                <strong>Catatan Dosen</strong>
                <p>{{ $kegiatan->catatan_dosen ?? '-' }}</p>
            </div>


        </div>

    </div>

</div>

<script>

function approveKegiatan(id)
{
    Swal.fire({
        title: 'Alasan Persetujuan',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan kegiatan disetujui...',
        showCancelButton: true,
        confirmButtonText: 'Setujui',

        inputValidator: (value) => {
            if (!value) {
                return 'Alasan wajib diisi';
            }
        }

    }).then((result) => {

        if(result.isConfirmed){

            let form = document.createElement('form');

            form.method = 'POST';
            form.action = '/dosen/kegiatan/' + id + '/approve';

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="catatan_dosen" value="${result.value}">
            `;

            document.body.appendChild(form);
            form.submit();
        }

    });
}

function rejectKegiatan(id)
{
    Swal.fire({
        title: 'Alasan Penolakan',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan kegiatan ditolak...',
        showCancelButton: true,
        confirmButtonText: 'Tolak',

        inputValidator: (value) => {
            if (!value) {
                return 'Alasan wajib diisi';
            }
        }

    }).then((result) => {

        if(result.isConfirmed){

            let form = document.createElement('form');

            form.method = 'POST';
            form.action = '/dosen/kegiatan/' + id + '/reject';

            form.innerHTML = `
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="catatan_dosen" value="${result.value}">
            `;

            document.body.appendChild(form);
            form.submit();
        }

    });
}

</script>

</x-app-layout>