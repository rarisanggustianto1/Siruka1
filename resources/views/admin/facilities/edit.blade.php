@extends('layouts.admin')

@section('title', 'Ubah Fasilitas - ' . $facility->nama_fasilitas)
@section('page_title', 'Ubah Master Fasilitas')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.facilities.index') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
            &larr; Kembali ke Master Fasilitas
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <h2 class="text-base font-bold text-slate-900 mb-1">Ubah Nama Fasilitas</h2>
        <p class="text-xs text-slate-500 mb-6">Perbarui nama master fasilitas yang digunakan pada ruangan kampus.</p>

        <form action="{{ route('admin.facilities.update', $facility) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nama_fasilitas" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                    Nama Fasilitas <span class="text-rose-500">*</span>
                </label>
                <input type="text" id="nama_fasilitas" name="nama_fasilitas" value="{{ old('nama_fasilitas', $facility->nama_fasilitas) }}" required
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.facilities.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-md shadow-indigo-600/25 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
