<section>

    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="POST"
          action="{{ route('profile.update') }}"
          class="space-y-6">

        @csrf
        @method('PATCH')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Nama --}}
            <div>
                <label for="name"
                       class="block text-sm font-semibold text-slate-700 mb-2">
                    Nama Lengkap
                </label>

                <div class="relative">
                    <i class="fas fa-user absolute left-4 top-3.5 text-slate-400"></i>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name',$user->name) }}"
                        required
                        autofocus
                        autocomplete="name"
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                <x-input-error
                    :messages="$errors->get('name')"
                    class="mt-2"/>
            </div>

            {{-- NIM --}}
            <div>
                <label for="nim"
                       class="block text-sm font-semibold text-slate-700 mb-2">
                    NIM
                </label>

                <div class="relative">
                    <i class="fas fa-id-card absolute left-4 top-3.5 text-slate-400"></i>

                    <input
                        id="nim"
                        name="nim"
                        type="text"
                        value="{{ old('nim',$user->nim) }}"
                        required
                        autocomplete="nim"
                        class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>

                <x-input-error
                    :messages="$errors->get('nim')"
                    class="mt-2"/>
            </div>

        </div>

        {{-- Program Studi --}}
<div>

    <label for="prodi"
           class="block text-sm font-semibold text-slate-700 mb-2">
        Program Studi
    </label>

    @if($user->hasRole('Mahasiswa'))

        <div class="relative">

            <i class="fas fa-graduation-cap absolute left-4 top-3.5 text-slate-400"></i>

            <select
                id="prodi"
                name="prodi"
                required
                class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

                <option value="">Pilih Program Studi</option>

                @foreach($prodis as $prodi)

                    <option
                        value="{{ $prodi->nama_prodi }}"
                        {{ old('prodi', $user->prodi) == $prodi->nama_prodi ? 'selected' : '' }}>

                        {{ $prodi->nama_prodi }}

                    </option>

                @endforeach

            </select>

        </div>

    @else

        <div class="relative">

            <i class="fas fa-graduation-cap absolute left-4 top-3.5 text-slate-400"></i>

            <input
                id="prodi"
                name="prodi"
                type="text"
                value="{{ old('prodi', $user->prodi) }}"
                placeholder="Masukkan Program Studi (Opsional)"
                autocomplete="prodi"
                class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

        </div>

        <p class="mt-2 text-xs text-slate-500">
            Program Studi bersifat opsional untuk Admin dan Dosen.
        </p>

    @endif

    <x-input-error
        :messages="$errors->get('prodi')"
        class="mt-2"/>

</div>

        {{-- Email --}}
        <div>

            <label for="email"
                   class="block text-sm font-semibold text-slate-700 mb-2">
                Email
            </label>

            <div class="relative">

                <i class="fas fa-envelope absolute left-4 top-3.5 text-slate-400"></i>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email',$user->email) }}"
                    required
                    autocomplete="username"
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">

            </div>

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"/>

        </div>

        {{-- Verifikasi Email --}}
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

            <div class="rounded-xl bg-yellow-50 border border-yellow-200 p-4">

                <div class="flex items-start gap-3">

                    <i class="fas fa-circle-exclamation text-yellow-500 mt-1"></i>

                    <div>

                        <p class="text-sm font-semibold text-yellow-800">
                            Email belum diverifikasi
                        </p>

                        <p class="text-sm text-yellow-700 mt-1">
                            Silakan verifikasi email Anda terlebih dahulu.
                        </p>

                        <button
                            form="send-verification"
                            class="mt-3 text-sm font-semibold text-blue-600 hover:text-blue-700">

                            Kirim ulang email verifikasi

                        </button>

                    </div>

                </div>

            </div>

        @endif

        {{-- Tombol --}}
        <div class="pt-2 flex items-center gap-4">

            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg hover:scale-[1.02] transition">

                <i class="fas fa-floppy-disk"></i>

                Simpan Perubahan

            </button>

            @if(session('status')==='profile-updated')

                <span
                    x-data="{show:true}"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(()=>show=false,2500)"
                    class="text-emerald-600 text-sm font-medium">

                    ✔ Profil berhasil diperbarui

                </span>

            @endif

        </div>

    </form>

</section>