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

        <form method="GET" action="{{ route('admin.users.approval.index') }}" class="mb-4 flex flex-wrap gap-3 items-end">
            <div class="flex-1 min-w-[200px]">
                <label for="search" class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Cari</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Nama, NIM, atau Email..."
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            </div>
            <div class="w-full md:w-40">
                <label for="role" class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Role</label>
                <select name="role" id="role" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none transition bg-white">
                    <option value="">Semua Role</option>
                    @foreach(['Mahasiswa','Dosen'] as $r)
                        <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                <i class="fas fa-search mr-1"></i> Filter
            </button>
            @if(request('search') || request('role'))
                <a href="{{ route('admin.users.approval.index') }}" class="bg-white border border-slate-300 hover:bg-slate-100 text-slate-700 px-5 py-2.5 rounded-xl text-sm font-semibold transition text-center">
                    Reset
                </a>
            @endif
        </form>

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
                        <input type="checkbox" id="send_email_reject" checked class="w-4 h-4 text-blue-600 rounded">
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
            if (!result.isConfirmed) return;

            fetch('/admin/users/' + id + '/reject', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ send_email: document.getElementById('send_email_reject').checked ? 1 : 0 })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 2000, showConfirmButton: false });
                    setTimeout(() => location.reload(), 2200);
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                }
            })
            .catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan' }));
        });
    }

    function confirmApprove(id) {
        Swal.fire({
            title: 'Setujui Akun?',
            html: `
                <p class="text-left text-sm text-gray-600">Mahasiswa akan dapat login ke sistem.</p>
                <div class="mt-4 text-left">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" id="send_email_approve" checked class="w-4 h-4 text-blue-600 rounded">
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
            if (!result.isConfirmed) return;

            fetch('/admin/users/' + id + '/approve', {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                body: JSON.stringify({ send_email: document.getElementById('send_email_approve').checked ? 1 : 0 })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: data.message, timer: 2000, showConfirmButton: false });
                    setTimeout(() => location.reload(), 2200);
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: data.message });
                }
            })
            .catch(() => Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan' }));
        });
    }
    </script>

</x-app-layout>