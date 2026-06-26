<section>

    <form method="POST"
          action="{{ route('password.update') }}"
          class="space-y-6">

        @csrf
        @method('PUT')

        {{-- Password Lama --}}
        <div>

            <label for="update_password_current_password"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Password Lama

            </label>

            <div class="relative">

                <i class="fas fa-lock absolute left-4 top-3.5 text-slate-400"></i>

                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="Masukkan password lama"
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">

            </div>

            <x-input-error
                :messages="$errors->updatePassword->get('current_password')"
                class="mt-2"/>

        </div>

        {{-- Password Baru --}}
        <div>

            <label for="update_password_password"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Password Baru

            </label>

            <div class="relative">

                <i class="fas fa-key absolute left-4 top-3.5 text-slate-400"></i>

                <input
                    id="update_password_password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">

            </div>

            <x-input-error
                :messages="$errors->updatePassword->get('password')"
                class="mt-2"/>

        </div>

        {{-- Konfirmasi Password --}}
        <div>

            <label for="update_password_password_confirmation"
                class="block text-sm font-semibold text-slate-700 mb-2">

                Konfirmasi Password Baru

            </label>

            <div class="relative">

                <i class="fas fa-shield-halved absolute left-4 top-3.5 text-slate-400"></i>

                <input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                    class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition">

            </div>

            <x-input-error
                :messages="$errors->updatePassword->get('password_confirmation')"
                class="mt-2"/>

        </div>

        {{-- Tips --}}
        <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-5">

            <div class="flex gap-3">

                <i class="fas fa-shield text-emerald-600 mt-1"></i>

                <div>

                    <h4 class="font-semibold text-emerald-800">
                        Tips Keamanan
                    </h4>

                    <ul class="mt-2 text-sm text-emerald-700 space-y-1 list-disc list-inside">
                        <li>Gunakan minimal 8 karakter.</li>
                        <li>Gabungkan huruf besar, huruf kecil, angka, dan simbol.</li>
                        <li>Jangan gunakan password yang sama dengan akun lain.</li>
                    </ul>

                </div>

            </div>

        </div>

        {{-- Tombol --}}
        <div class="flex items-center gap-4">

            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-semibold shadow-lg hover:scale-[1.02] transition">

                <i class="fas fa-key"></i>

                Update Password

            </button>

            @if(session('status') === 'password-updated')

                <span
                    x-data="{show:true}"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(()=>show=false,2500)"
                    class="text-emerald-600 font-medium text-sm">

                    ✔ Password berhasil diperbarui

                </span>

            @endif

        </div>

    </form>

</section>