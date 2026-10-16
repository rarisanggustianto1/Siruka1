@extends('layouts.admin')

@section('title', 'Tolak Pengajuan Booking')
@section('page_title', 'Tolak Pengajuan Booking')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-slate-800 transition-colors">
            &larr; Kembali ke Daftar Booking
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 bg-rose-50/60 border-b border-rose-100 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div>
                <h2 class="text-base font-bold text-slate-900">Formulir Penolakan Peminjaman Ruangan</h2>
                <p class="text-xs text-slate-500">Wajib mengisi alasan penolakan secara jelas untuk disampaikan kepada peminjam.</p>
            </div>
        </div>

        <!-- Ringkasan Booking yang Akan Ditolak -->
        <div class="p-6 bg-slate-50/70 border-b border-slate-200 text-xs text-slate-700 space-y-2">
            <div class="flex justify-between">
                <span class="text-slate-500">Peminjam:</span>
                <span class="font-bold text-slate-900">{{ $booking->user->name }} (NIM: {{ $booking->user->nim_nip ?? '-' }})</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Ruangan:</span>
                <span class="font-bold text-slate-900">{{ $booking->room->nama }} &bull; {{ $booking->room->gedung }} (Lt. {{ $booking->room->lantai }})</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Jadwal Tanggal & Jam:</span>
                <span class="font-bold text-indigo-700">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('dddd, D MMMM Y') }} ({{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB)</span>
            </div>
            <div class="flex justify-between">
                <span class="text-slate-500">Keperluan:</span>
                <span class="font-medium text-slate-800 text-right max-w-xs">{{ $booking->keperluan }}</span>
            </div>
        </div>

        <form action="{{ route('admin.bookings.reject', $booking) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            <div>
                <label for="alasan_penolakan" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                    Alasan Penolakan <span class="text-rose-500">* (Wajib Diisi)</span>
                </label>
                <textarea id="alasan_penolakan" name="alasan_penolakan" rows="5" required
                    placeholder="Contoh: Jadwal bertabrakan dengan agenda resmi rektorat, atau ruangan sedang dipersiapkan untuk ujian..."
                    class="w-full px-3.5 py-2.5 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-rose-500 focus:outline-none placeholder-slate-400">{{ old('alasan_penolakan') }}</textarea>
                <p class="text-[11px] text-slate-400 mt-1">Alasan ini akan langsung tampil di menu riwayat peminjaman peminjam bersangkutan.</p>
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-200">
                <a href="{{ route('admin.bookings.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-xs hover:bg-slate-50 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs shadow-md shadow-rose-600/25 transition-all">
                    Konfirmasi Tolak Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
