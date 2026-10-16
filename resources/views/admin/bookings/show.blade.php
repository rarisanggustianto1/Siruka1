@extends('layouts.admin')

@section('title', 'Rincian Booking #' . str_pad($booking->id, 5, '0', STR_PAD_LEFT))
@section('page_title', 'Rincian Pengajuan Booking')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb & Top Actions -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center text-xs font-bold text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar Booking
        </a>

        <div class="flex items-center space-x-2">
            @if($booking->status === 'menunggu')
                <form action="{{ route('admin.bookings.approve', $booking) }}" method="POST">
                    @csrf
                    <button type="submit" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Setujui Booking
                    </button>
                </form>

                <a href="{{ route('admin.bookings.reject_form', $booking) }}"
                    class="px-3.5 py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    Tolak Pengajuan
                </a>
            @endif

            @if($booking->status === 'disetujui')
                <a href="{{ route('admin.bookings.cetak', $booking) }}" target="_blank"
                    class="px-3.5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs shadow-sm transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Surat Bukti Izin
                </a>
            @endif
        </div>
    </div>

    <!-- Status Header Banner -->
    <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $booking->status_badge_class }}">
                    {{ $booking->status_label }}
                </span>
                <span class="font-mono text-xs text-slate-400 font-bold">#BK-{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 mt-2">{{ $booking->room->nama }}</h1>
            <p class="text-xs text-slate-500 mt-1">Didaftarkan: {{ \Carbon\Carbon::parse($booking->created_at)->isoFormat('dddd, D MMMM Y - HH:mm') }} WIB</p>
        </div>

        <div class="text-left sm:text-right bg-slate-50 sm:bg-transparent p-4 sm:p-0 rounded-2xl">
            <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider">Jadwal Penggunaan</p>
            <p class="text-base font-extrabold text-indigo-700 mt-0.5">{{ \Carbon\Carbon::parse($booking->tanggal)->isoFormat('dddd, D MMMM Y') }}</p>
            <p class="text-sm font-mono font-bold text-slate-800">{{ substr($booking->jam_mulai, 0, 5) }} - {{ substr($booking->jam_selesai, 0, 5) }} WIB</p>
        </div>
    </div>

    @if($booking->status === 'ditolak' && $booking->alasan_penolakan)
        <!-- Rejection Note -->
        <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 flex items-start space-x-3 shadow-sm">
            <svg class="w-6 h-6 text-rose-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div>
                <h4 class="font-bold text-sm">Alasan Penolakan yang Tercatat:</h4>
                <p class="text-xs text-rose-800 mt-1 leading-relaxed">{{ $booking->alasan_penolakan }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left: Detail Kegiatan & Ruangan (2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Rincian Agenda -->
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Keperluan & Agenda Acara</h3>
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 text-sm text-slate-800 leading-relaxed font-medium">
                    "{{ $booking->keperluan }}"
                </div>

                <div class="grid grid-cols-2 gap-4 pt-2">
                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50">
                        <span class="text-xs text-slate-400 font-medium">Estimasi Peserta</span>
                        <p class="text-base font-extrabold text-slate-900 mt-1">{{ $booking->jumlah_peserta }} Orang</p>
                        <span class="text-[11px] text-slate-500">Maks. Kapasitas: {{ $booking->room->kapasitas }} org</span>
                    </div>

                    <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/50">
                        <span class="text-xs text-slate-400 font-medium">Status Ruangan</span>
                        <p class="text-base font-extrabold text-slate-900 mt-1 capitalize">{{ $booking->room->status }}</p>
                        <span class="text-[11px] text-slate-500">{{ $booking->room->gedung }} (Lt. {{ $booking->room->lantai }})</span>
                    </div>
                </div>
            </div>

            <!-- Rincian Ruangan -->
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                <div class="h-44 bg-slate-100 relative">
                    <img src="{{ $booking->room->foto_url }}" alt="{{ $booking->room->nama }}" class="w-full h-full object-cover">
                    <div class="absolute bottom-3 left-4">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-slate-900/80 text-white backdrop-blur-sm">
                            {{ $booking->room->kode }}
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <h3 class="text-base font-extrabold text-slate-900">{{ $booking->room->nama }}</h3>
                    <p class="text-xs text-slate-500 mt-0.5">{{ $booking->room->gedung }} &bull; Lantai {{ $booking->room->lantai }}</p>
                    <p class="text-xs text-slate-600 mt-3 leading-relaxed">{{ $booking->room->deskripsi ?? 'Ruangan serbaguna kampus.' }}</p>

                    <div class="mt-4 pt-4 border-t border-slate-100">
                        <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-2">Fasilitas Ruangan:</span>
                        <div class="flex flex-wrap gap-1.5">
                            @forelse($booking->room->facilities as $f)
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-800 text-xs font-medium border border-slate-200">
                                    ✓ {{ $f->nama_fasilitas }}
                                </span>
                            @empty
                                <span class="text-xs text-slate-400">Fasilitas standar</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Info Pemohon (1 Col) -->
        <div class="space-y-6">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm space-y-4">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Identitas Mahasiswa Peminjam</h3>

                <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center font-bold text-indigo-700 text-sm">
                        {{ substr($booking->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-extrabold text-sm text-slate-900">{{ $booking->user->name }}</p>
                        <p class="text-xs text-slate-500">Mahasiswa</p>
                    </div>
                </div>

                <div class="space-y-2.5 text-xs">
                    <div>
                        <span class="text-slate-400 font-medium">NIM:</span>
                        <p class="font-mono font-bold text-slate-800 mt-0.5">{{ $booking->user->nim_nip ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium">Email Kampus:</span>
                        <p class="font-semibold text-slate-800 mt-0.5">{{ $booking->user->email }}</p>
                    </div>
                    <div>
                        <span class="text-slate-400 font-medium">No. WhatsApp / HP:</span>
                        <p class="font-semibold text-slate-800 mt-0.5">{{ $booking->user->no_hp ?? '-' }}</p>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data booking ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 px-3 rounded-xl border border-rose-200 text-rose-600 hover:bg-rose-50 text-xs font-bold transition-colors">
                            Hapus Data Peminjaman
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
