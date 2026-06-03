<x-app-layout>

<div class="py-6">

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">
                Validasi SPK
            </h1>

            <p class="text-gray-500 mt-1">
                Persetujuan SPK Mahasiswa
            </p>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">

            <table class="w-full text-sm text-left text-gray-600">

                <thead class="bg-gray-50 uppercase text-xs tracking-wider">

                    <tr>
                        <th class="px-6 py-4 text-center">No</th>
                        <th class="px-6 py-4">Mahasiswa</th>
                        <th class="px-6 py-4">NIM</th>
                        <th class="px-6 py-4">Prodi</th>
                        <th class="px-6 py-4">RPK</th>
                        <th class="px-6 py-4">Kegiatan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($spks as $spk)

                    <tr class="border-b hover:bg-blue-50 transition">

                        <td class="px-6 py-4 text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium text-gray-800">
                             {{ $spk->user->name }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->user->nim }}
                        </td>

                        <td class="px-6 py-4">
                             {{ $spk->user->prodi }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->rpk->tahun }}
                            -
                            {{ $spk->rpk->semester }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $spk->kegiatan->kegiatan }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($spk->status == 'draft')

                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Draft
                                </span>

                            @elseif($spk->status == 'disetujui')

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Disetujui
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">
                                    Ditolak
                                </span>

                            @endif

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

        <a href="{{ route('dosen.spk.show', $spk->id) }}"
           class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">

            Detail

        </a>

                            @if($spk->status == 'draft')


                            <div class="flex justify-center gap-2">

                                

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

                            </div>

                            @else

                            <span class="text-gray-400">
                                Selesai
                            </span>

                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="text-center py-10 text-gray-400">

                            Belum ada data SPK

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

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