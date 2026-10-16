@extends('layouts.app')

@section('title', 'Daftar Akun Peminjam')

@section('content')
<div class="min-h-[85vh] flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <div class="inline-flex w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-600 items-center justify-center shadow-lg shadow-indigo-500/25 mb-4">
            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
        </div>
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Registrasi Mahasiswa</h2>
        <p class="mt-2 text-sm text-slate-600">
            Daftarkan akun Mahasiswa Anda untuk mengajukan peminjaman ruangan kampus
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="bg-white py-8 px-6 shadow-xl shadow-slate-200/60 rounded-3xl sm:px-10 border border-slate-100">
            <form class="space-y-4" action="{{ route('register.post') }}" method="POST">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap Mahasiswa</label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                            class="appearance-none block w-full px-4 py-2.5 border border-slate-300 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm transition-all"
                            placeholder="Contoh: Alya Putri Rahmadani">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="nim_nip" class="block text-sm font-semibold text-slate-700">NIM (Nomor Induk Mahasiswa)</label>
                        <div class="mt-1">
                            <input id="nim_nip" name="nim_nip" type="text" required value="{{ old('nim_nip') }}"
                                class="appearance-none block w-full px-4 py-2.5 border border-slate-300 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition-all"
                                placeholder="Contoh: 2201010042">
                        </div>
                    </div>

                    <div>
                        <label for="no_hp" class="block text-sm font-semibold text-slate-700">No. HP / WhatsApp</label>
                        <div class="mt-1">
                            <input id="no_hp" name="no_hp" type="text" required value="{{ old('no_hp') }}"
                                class="appearance-none block w-full px-4 py-2.5 border border-slate-300 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition-all"
                                placeholder="08123456789">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Alamat Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="appearance-none block w-full px-4 py-2.5 border border-slate-300 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition-all"
                            placeholder="nama@kampus.ac.id">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required
                                class="appearance-none block w-full px-4 py-2.5 border border-slate-300 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition-all"
                                placeholder="Min. 6 karakter">
                        </div>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Ulangi Sandi</label>
                        <div class="mt-1">
                            <input id="password_confirmation" name="password_confirmation" type="password" required
                                class="appearance-none block w-full px-4 py-2.5 border border-slate-300 rounded-xl placeholder-slate-400 text-slate-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm transition-all"
                                placeholder="Konfirmasi sandi">
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md shadow-indigo-500/25 text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        Daftar Sebagai Peminjam
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-xs text-slate-600">
                    Sudah memiliki akun?
                    <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-500">
                        Masuk disini
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
