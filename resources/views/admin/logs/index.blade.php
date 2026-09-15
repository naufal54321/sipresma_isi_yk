<x-app-layout>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            toast: true,
            position: 'top-end'
        });
    </script>
    @endif

    <div class="py-6">
        <div class="max-w-8xl mx-auto py-6">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Log & Aktivitas</h1>
                    <p class="text-gray-500 mt-1">Riwayat aktivitas sistem dan pengguna</p>
                </div>
                <div class="text-sm text-gray-400">
                    {{ number_format($activities->total()) }} total log
                </div>
            </div>

            {{-- Filter --}}
            <div class="bg-white shadow rounded-xl p-4 mb-4">
                <form method="GET" action="{{ route('admin.logs.index') }}" class="flex flex-col md:flex-row items-center gap-3 flex-wrap">

                    <div class="relative w-full md:w-64 flex-shrink-0">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari deskripsi..."
                               class="w-full border border-gray-300 rounded-xl pl-10 pr-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 absolute left-3 top-3 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z"/>
                        </svg>
                    </div>

                    <select name="user_id" class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">Semua User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>

                    <select name="model" class="w-full md:w-48 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">Semua Model</option>
                        @foreach($models as $label => $class)
                            <option value="{{ class_basename($class) }}" {{ request('model') == class_basename($class) ? 'selected' : '' }}>{{ class_basename($class) }}</option>
                        @endforeach
                    </select>

                    <select name="event" class="w-full md:w-40 border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition">
                        <option value="">Semua Aksi</option>
                        @foreach($events as $event)
                            <option value="{{ $event }}" {{ request('event') == $event ? 'selected' : '' }}>{{ ucfirst($event) }}</option>
                        @endforeach
                    </select>

                    <input type="date" name="date_from" value="{{ request('date_from') }}" placeholder="Dari tanggal"
                           class="w-full md:w-44 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition">
                    <span class="text-gray-400 text-sm hidden md:inline">—</span>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" placeholder="Sampai tanggal"
                           class="w-full md:w-44 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 transition">

                    <div class="flex gap-2 w-full md:w-auto">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold transition w-full md:w-auto">
                            <i class="fas fa-search mr-1"></i> Cari
                        </button>
                        @if(request()->hasAny(['search', 'user_id', 'model', 'event', 'date_from', 'date_to']))
                            <a href="{{ route('admin.logs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-xl text-sm font-semibold transition w-full md:w-auto">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="bg-gray-50 uppercase text-xs tracking-wider border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-4 text-center w-12">No</th>
                                <th class="px-4 py-4">Waktu</th>
                                <th class="px-4 py-4">User</th>
                                <th class="px-4 py-4">Aksi</th>
                                <th class="px-4 py-4">Model</th>
                                <th class="px-4 py-4">Deskripsi</th>
                                <th class="px-4 py-4">Detail</th>
                                <th class="px-4 py-4 text-center w-20">Hapus</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($activities as $activity)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-4 py-4 text-center">
                                    {{ ($activities->currentPage() - 1) * $activities->perPage() + $loop->iteration }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-gray-500 text-xs">
                                    {{ $activity->created_at->format('d M Y') }}<br>
                                    <span class="text-gray-400">{{ $activity->created_at->format('H:i:s') }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    @if($activity->causer)
                                        <span class="font-medium text-gray-800">{{ $activity->causer->name }}</span>
                                        <br><span class="text-xs text-gray-400">{{ $activity->causer->email }}</span>
                                    @else
                                        <span class="text-gray-400 italic">System</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    @php
                                        $event = $activity->event ?? 'created';
                                        $badgeColors = [
                                            'created' => 'bg-green-100 text-green-700 border-green-200',
                                            'updated' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'deleted' => 'bg-red-100 text-red-700 border-red-200',
                                            'login' => 'bg-purple-100 text-purple-700 border-purple-200',
                                            'logout' => 'bg-gray-100 text-gray-600 border-gray-200',
                                            'login_failed' => 'bg-red-100 text-red-700 border-red-200',
                                            'registered' => 'bg-teal-100 text-teal-700 border-teal-200',
                                        ];
                                        $color = $badgeColors[$event] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $color }}">
                                        @if(in_array($event, ['created', 'login', 'registered']))
                                            <i class="fas fa-plus-circle mr-1 text-[10px]"></i>
                                        @elseif($event === 'updated')
                                            <i class="fas fa-pen mr-1 text-[10px]"></i>
                                        @elseif($event === 'deleted')
                                            <i class="fas fa-trash mr-1 text-[10px]"></i>
                                        @elseif($event === 'login_failed')
                                            <i class="fas fa-exclamation-triangle mr-1 text-[10px]"></i>
                                        @endif
                                        {{ ucfirst(str_replace('_', ' ', $event)) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    @if($activity->subject_type)
                                        <span class="inline-flex items-center px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-medium">
                                            {{ class_basename($activity->subject_type) }}
                                        </span>
                                        <span class="text-xs text-gray-400 ml-1">#{{ $activity->subject_id }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-gray-700">
                                    {{ $activity->description }}
                                </td>
                                <td class="px-4 py-4">
                                    @php $attrChanges = $activity->attribute_changes ?? collect(); @endphp
                                    @php $props = $activity->properties ?? collect(); @endphp
                                    @php
                                        $fieldLabels = [
                                            'status' => 'Status',
                                            'dosen_pembimbing_id' => 'Dosen Pembimbing',
                                            'judul_kegiatan' => 'Judul Kegiatan',
                                            'tanggal_mulai' => 'Tanggal Mulai',
                                            'tanggal_selesai' => 'Tanggal Selesai',
                                            'penyelenggara' => 'Penyelenggara',
                                            'peran_sifat' => 'Peran/Sifat',
                                            'bidang' => 'Bidang',
                                            'point_rule_id' => 'Aturan Poin',
                                            'poin' => 'Poin',
                                            'catatan_dosen' => 'Catatan Dosen',
                                            'catatan_admin' => 'Catatan Admin',
                                            'verified_by' => 'Diverifikasi Oleh',
                                            'verified_at' => 'Waktu Verifikasi',
                                            'poin_added_at' => 'Waktu Poin Ditambahkan',
                                            'poin_added_by' => 'Poin Ditambahkan Oleh',
                                            'name' => 'Nama',
                                            'email' => 'Email',
                                            'nim' => 'NIM',
                                            'angkatan' => 'Angkatan',
                                            'semester' => 'Semester',
                                            'is_active' => 'Status Aktif',
                                            'points' => 'Poin',
                                            'max_usage' => 'Maks Penggunaan',
                                            'updated_at' => 'Terakhir Diperbarui',
                                            'created_at' => 'Dibuat',
                                            'ip' => 'IP Address',
                                            'user_agent' => 'Browser',
                                            'log_name' => 'Log Name',
                                            'description' => 'Deskripsi',
                                            'subject_type' => 'Tipe Subject',
                                            'subject_id' => 'ID Subject',
                                            'causer_type' => 'Tipe Pelaku',
                                            'causer_id' => 'ID Pelaku',
                                            'event' => 'Event',
                                            'activity_type_id' => 'Tipe Aktivitas',
                                            'scope_id' => 'Ruang Lingkup',
                                            'role_id' => 'Peran',
                                            'achievement_id' => 'Prestasi',
                                            'competency_field_id' => 'Bidang Kompetensi',
                                            'prodi' => 'Program Studi',
                                        ];
                                    @endphp
                                    @if($attrChanges->isNotEmpty())
                                        <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-blue-500 hover:text-blue-700 transition" title="Lihat perubahan">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <div class="hidden mt-2 bg-gray-50 border border-gray-200 rounded-lg p-3 text-xs max-w-xs overflow-auto">
                                            @if(isset($attrChanges['old']))
                                                <div class="mb-2">
                                                    <span class="font-semibold text-red-600">Sebelum:</span>
                                                    <ul class="list-disc pl-4 mt-1 space-y-0.5">
                                                        @foreach($attrChanges['old'] as $key => $val)
                                                            <li><span class="text-gray-500">{{ $fieldLabels[$key] ?? str_replace('_', ' ', ucfirst($key)) }}:</span> <span class="text-red-600">{{ is_array($val) ? json_encode($val) : $val }}</span></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                            @if(isset($attrChanges['attributes']))
                                                <div>
                                                    <span class="font-semibold text-green-600">Sesudah:</span>
                                                    <ul class="list-disc pl-4 mt-1 space-y-0.5">
                                                        @foreach($attrChanges['attributes'] as $key => $val)
                                                            <li><span class="text-gray-500">{{ $fieldLabels[$key] ?? str_replace('_', ' ', ucfirst($key)) }}:</span> <span class="text-green-600">{{ is_array($val) ? json_encode($val) : $val }}</span></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($props->isNotEmpty())
                                        <button onclick="this.nextElementSibling.classList.toggle('hidden')" class="text-blue-500 hover:text-blue-700 transition" title="Lihat detail">
                                            <i class="fas fa-eye text-xs"></i>
                                        </button>
                                        <div class="hidden mt-2 bg-gray-50 border border-gray-200 rounded-lg p-3 text-xs max-w-xs">
                                            @foreach($props->toArray() as $key => $val)
                                                <div><span class="text-gray-500">{{ $fieldLabels[$key] ?? str_replace('_', ' ', ucfirst($key)) }}:</span> <span class="text-gray-700">{{ is_array($val) ? json_encode($val) : $val }}</span></div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-center">
                                    <button onclick="hapusLog({{ $activity->id }})" class="text-red-400 hover:text-red-600 transition" title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-10 text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-clock-rotate-left text-4xl mb-3 text-gray-300"></i>
                                        <p class="font-medium">Belum ada log aktivitas</p>
                                        <p class="text-sm mt-1">Aktivitas akan tercatat secara otomatis</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($activities->hasPages())
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $activities->withQueryString()->links() }}
                </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var csrfToken = '{{ csrf_token() }}';
        var baseUrl = '{{ route("admin.logs.index") }}';

        function hapusLog(id) {
            Swal.fire({
                title: 'Hapus Log?',
                text: 'Log ini akan dihapus permanen',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#9CA3AF',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`${baseUrl}/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(json => {
                        if (json.success) {
                            Swal.fire({ icon: 'success', title: 'Berhasil!', text: json.message, timer: 2000, showConfirmButton: false })
                            .then(() => location.reload());
                        }
                    })
                    .catch(() => {
                        Swal.fire('Gagal', 'Terjadi kesalahan', 'error');
                    });
                }
            });
        }
    </script>
</x-app-layout>
