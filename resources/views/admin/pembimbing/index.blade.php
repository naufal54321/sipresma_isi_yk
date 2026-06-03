<x-app-layout>

<div class="py-6 max-w-7xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">
        Penentuan Dosen Pembimbing
    </h1>

    <!-- FORM ASSIGN -->
    <div class="bg-white p-6 rounded-xl shadow mb-6">

        <form method="POST" action="{{ route('admin.pembimbing.set') }}">
            @csrf

            <div class="grid grid-cols-2 gap-4">

                <div>
                    <label class="text-sm font-medium">Mahasiswa</label>
                    <select name="mahasiswa_id" class="w-full border rounded p-2 mt-1">
                        @foreach($mahasiswa as $mhs)
                            <option value="{{ $mhs->id }}">
                                {{ $mhs->name }} - {{ $mhs->nim }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-sm font-medium">Dosen Pembimbing</label>
                    <select name="dosen_id" class="w-full border rounded p-2 mt-1">
                        @foreach($dosen as $dsn)
                            <option value="{{ $dsn->id }}">
                                {{ $dsn->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
                Simpan / Update
            </button>

        </form>

    </div>

    <!-- TABLE -->
    <div class="bg-white shadow rounded-xl overflow-hidden">

        <table class="w-full text-sm">

            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="p-3">No</th>
                    <th class="p-3">Mahasiswa</th>
                    <th class="p-3">NIM</th>
                    <th class="p-3">Prodi</th>
                    <th class="p-3">Dosen Pembimbing</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>

            <tbody>

                @foreach($mahasiswa as $mhs)

                <tr class="border-b hover:bg-gray-50">

                    <td class="p-3">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-3 font-medium">
                        {{ $mhs->name }}
                    </td>

                    <td class="p-3">
                        {{ $mhs->nim }}
                    </td>
                    <td class="p-3">
                        {{ $mhs->prodi }}
                    </td>

                    <td class="p-3">
                        {{ $mhs->dosenPembimbing->name ?? '-' }}
                    </td>

                    <td class="p-3">

                        @if($mhs->dosen_pembimbing_id)
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                Sudah Ada
                            </span>
                        @else
                            <span class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">
                                Belum
                            </span>
                        @endif

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</x-app-layout>