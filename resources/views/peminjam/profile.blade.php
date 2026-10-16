@extends('layouts.peminjam')

@section('title', 'Profil Akun Saya')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200 bg-slate-50/60 flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center text-white text-xl font-bold shadow-md shadow-indigo-500/20">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-xl font-black text-slate-900 tracking-tight">{{ $user->name }}</h1>
                <p class="text-xs text-slate-500">NIM: <span class="font-semibold text-slate-700">{{ $user->nim_nip ?? 'Belum disetel' }}</span> &bull; Role: <span class="text-indigo-600 font-bold uppercase">{{ $user->role === 'peminjam' ? 'Mahasiswa' : $user->role }}</span></p>
            </div>
        </div>

        <form action="{{ route('peminjam.profile.update') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Informasi Kontak & Identitas -->
            <div class="space-y-4">
                <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Informasi Profil</h2>

                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Lengkap Mahasiswa <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Alamat Email (Tidak dapat diubah)
                        </label>
                        <input type="email" value="{{ $user->email }}" disabled
                            class="w-full px-3.5 py-2.5 text-sm border border-slate-200 bg-slate-100 text-slate-500 rounded-xl cursor-not-allowed">
                    </div>

                    <div>
                        <label for="no_hp" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Nomor WhatsApp / HP
                        </label>
                        <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                            placeholder="08123456789"
                            class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <!-- Ganti Password -->
            <div class="pt-6 border-t border-slate-200 space-y-4">
                <div>
                    <h2 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Ganti Kata Sandi</h2>
                    <p class="text-xs text-slate-400">Kosongkan bagian ini jika Anda tidak ingin mengubah kata sandi.</p>
                </div>

                <div>
                    <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Kata Sandi Saat Ini
                    </label>
                    <input type="password" id="current_password" name="current_password"
                        placeholder="••••••••"
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="new_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Kata Sandi Baru
                        </label>
                        <input type="password" id="new_password" name="new_password"
                            placeholder="Min. 6 karakter"
                            class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>

                    <div>
                        <label for="new_password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Ulangi Sandi Baru
                        </label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                            placeholder="Konfirmasi sandi"
                            class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-200 flex justify-end">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/25 transition-all">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
