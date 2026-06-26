<x-app-layout>

    @php
        \Carbon\Carbon::setLocale('id');
    @endphp

    <div class="max-w-8xl mx-auto py-6">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Persetujuan Akun Mahasiswa
                </h1>
                <p class="text-gray-500 mt-1">
                    Daftar akun yang menunggu persetujuan
                </p>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-2 text-sm text-blue-700 font-semibold">
                <i class="fas fa-users mr-1"></i> {{ $users->count() }} Menunggu
            </div>
        </div>

        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b-2 border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-center w-12">No</th>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">NIM</th>
                            <th class="px-6 py-4">Prodi</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Tanggal Daftar</th>
                            <th class="px-6 py-4 text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr class="border-b hover:bg-blue-50 transition duration-150">
                            <td class="px-6 py-4 text-center font-bold text-gray-700">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-800">
                                {{ $user->nim }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $user->prodi }}
                            </td>
                            <td class="px-6 py-4 text-gray-500">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 font-medium">
                                    {{ $user->created_at->translatedFormat('d F Y') }}
                                </div>
                                <div class="text-xs text-gray-400">
                                    {{ $user->created_at->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <form id="approve-form-{{ $user->id }}"
                                          action="{{ route('admin.users.approve', $user->id) }}"
                                          method="POST" class="m-0">
                                        @csrf
                                        @method('PUT')
                                        <button type="button"
                                            onclick="confirmApprove({{ $user->id }})"
                                            class="flex items-center gap-1 bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm">
                                            <i class="fas fa-check-circle"></i> Setujui
                                        </button>
                                    </form>

                                    <form id="reject-form-{{ $user->id }}"
                                          action="{{ route('admin.users.reject', $user->id) }}"
                                          method="POST" class="m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmReject({{ $user->id }})"
                                            class="flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition shadow-sm">
                                            <i class="fas fa-times-circle"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <div class="flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-lg font-medium">Tidak ada akun yang menunggu persetujuan</p>
                                    <p class="text-sm mt-1">Semua pendaftar sudah diproses</p>
                                </div>
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
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
            customClass: { popup: 'rounded-2xl' }
        });
    </script>
    @endif

    <script>
    function confirmReject(id) {
        Swal.fire({
            title: 'Tolak Akun?',
            html: `
                <p class="text-left text-sm text-gray-600">Akun akan ditolak dan dihapus permanen.</p>
                <div class="mt-4 text-left">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="send_email" checked class="w-4 h-4 text-blue-600 rounded">
                        <span class="text-sm">Kirim email notifikasi</span>
                    </label>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Tolak',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('reject-form-' + id);
                const sendEmail = document.getElementById('send_email').checked ? 1 : 0;
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'send_email';
                input.value = sendEmail;
                form.appendChild(input);
                form.submit();
            }
        });
    }

    function confirmApprove(id) {
        Swal.fire({
            title: 'Setujui Akun?',
            html: `
                <p class="text-left text-sm text-gray-600">Mahasiswa akan dapat login ke sistem.</p>
                <div class="mt-4 text-left">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="send_email" checked class="w-4 h-4 text-blue-600 rounded">
                        <span class="text-sm">Kirim email notifikasi</span>
                    </label>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Setujui',
            cancelButtonText: 'Batal',
            customClass: { popup: 'rounded-2xl', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl' }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('approve-form-' + id);
                const sendEmail = document.getElementById('send_email').checked ? 1 : 0;
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'send_email';
                input.value = sendEmail;
                form.appendChild(input);
                form.submit();
            }
        });
    }
    </script>

</x-app-layout>