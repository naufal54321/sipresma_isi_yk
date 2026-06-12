<x-app-layout>

<div class="max-w-7xl mx-auto py-6">

    <div class="mb-6">
        <h1 class="text-3xl font-bold">
            Persetujuan Akun Mahasiswa
        </h1>

        <p class="text-gray-500">
            Daftar akun yang menunggu persetujuan
        </p>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full text-sm text-left text-gray-600">

            <thead class="bg-gray-50 text-black uppercase text-xs tracking-wider">

                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">NIM</th>
                    <th class="px-4 py-3">Prodi</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Tanggal Daftar</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr class="border-b">

                    <td class="px-4 py-3">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $user->name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $user->nim }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $user->prodi }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $user->email }}
                    </td>

                    <td class="px-4 py-3">
                    <div class="text-sm">
                        {{ $user->created_at->format('d M Y') }}
                    </div>
                    <div class="text-sm text-gray-500">
                        {{ $user->created_at->format('H:i') }} WIB
                    </div>
                    </td>

                    <td class="px-4 py-3">

                        <div class="flex gap-2">

                           <form id="approve-form-{{ $user->id }}"
                                action="{{ route('admin.users.approve', $user->id) }}"
                                method="POST">
                                @csrf
                                @method('PUT')

                                <button type="button"
                                    onclick="confirmApprove({{ $user->id }})"
                                    class="bg-green-600 hover:bg-green-500 text-white px-3 py-2 rounded">
                                    Setujui
                                </button>
                            </form>

                                                    <form id="reject-form-{{ $user->id }}"
                                action="{{ route('admin.users.reject', $user->id) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    onclick="confirmReject({{ $user->id }})"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">
                                    Tolak
                                </button>
                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7"
                        class="text-center py-8 text-gray-500">

                        Tidak ada akun yang menunggu persetujuan

                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonColor: '#3085d6'
    });
</script>
@endif

<script>
function confirmReject(id) {
    Swal.fire({
        title: 'Yakin?',
        text: 'Akun akan ditolak dan dihapus permanen.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('reject-form-' + id).submit();
        }
    });
}

function confirmApprove(id) {
    Swal.fire({
        title: 'Setujui akun?',
        text: 'Mahasiswa akan dapat login ke sistem.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Setujui',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('approve-form-' + id).submit();
        }
    });
}
</script>

</x-app-layout>