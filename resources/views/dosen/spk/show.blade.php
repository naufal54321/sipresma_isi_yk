<x-app-layout>
 <!-- Tombol -->
<div class="col-span-2 mt-6">

    <a href="{{ route('dosen.spk.index') }}"
       class="inline-flex items-center bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg transition">

        ← Kembali

    </a>

                            @if($spk->status == 'draft')


                                <button
                                    onclick="approveSpk({{ $spk->id }})"
                                    class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg">

                                    Setujui

                                </button>

                                <button
                                    onclick="rejectSpk({{ $spk->id }})"
                                    class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg">

                                    Tolak

                                </button>

                            @else

                            <span class="text-gray-400">
                                Selesai
                            </span>

                            @endif


</div>
<div class="max-w-8xl mx-auto py-6">
   

    <div class="bg-white shadow rounded-xl p-6">

        <h1 class="text-2xl font-bold mb-6">
            Detail SPK
        </h1>

        <h2 class="text-2xl font-medium mb-6">
            Data Mahasiswa
        </h2>

        <div class="grid grid-cols-2 gap-4">

            <div>
                <strong>Mahasiswa</strong>
                <p>{{ $spk->user->name }}</p>
            </div>

            <div>
    <strong>NIM</strong>
    <p>{{ $spk->user->nim }}</p>
</div>

<div>
    <strong>Program Studi</strong>
    <p>{{ $spk->user->prodi }}</p>
</div>

            <div>
                <strong>Tahun</strong>
                <p>{{ $spk->tahun }}</p>
            </div>

            <div>
                <strong>Kegiatan</strong>
                <p>{{ $spk->kegiatan->kegiatan }}</p>
            </div>

            <div>
                <strong>Jenis</strong>
                <p>{{ $spk->kegiatan->jenis }}</p>
            </div>

            <div>
                <strong>Penyelenggara</strong>
                <p>{{ $spk->penyelenggara }}</p>
            </div>

            <div>
                <strong>Tanggal</strong>
                <p>{{ $spk->tanggal_kegiatan }}</p>
            </div>

            <div class="col-span-2">
                <strong>Keterangan</strong>
                <p>{{ $spk->keterangan }}</p>
            </div>

            <div class="col-span-2 mt-6">

    <strong>Preview Bukti</strong>

    <iframe
        src="{{ asset('storage/' . $spk->bukti) }}"
        width="100%"
        height="700"
        class="border rounded-lg mt-2">

    </iframe>

</div>

        </div>

    </div>

</div>


<script>

function approveSpk(id)
{
    Swal.fire({
        title: 'Alasan Persetujuan',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan disetujui...',
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
            form.action = '/dosen/spk/' + id + '/approve';

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

function rejectSpk(id)
{
    Swal.fire({
        title: 'Alasan Penolakan',
        input: 'textarea',
        inputLabel: 'Catatan Dosen',
        inputPlaceholder: 'Masukkan alasan ditolak...',
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
            form.action = '/dosen/spk/' + id + '/reject';

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