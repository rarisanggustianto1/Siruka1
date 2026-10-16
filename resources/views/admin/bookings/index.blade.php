@extends('layouts.admin')

@section('title', 'Kelola Booking Ruangan')
@section('page_title', 'Kelola Pengajuan Booking')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">Semua Pengajuan Booking Ruangan</h2>
            <p class="text-xs text-slate-500 mt-0.5">Pantau, setujui, tolak, atau kelola riwayat peminjaman sarana prasarana kampus.</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm">
        <form action="{{ route('admin.bookings.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Cari Peminjam / Ruangan / Keperluan</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik kata kunci..."
                    class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Status Pengajuan</label>
                <select name="status" class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Persetujuan</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal Booking</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="w-full px-3.5 py-2 text-sm border border-slate-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:outline-none">
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 py-2 px-4 rounded-xl bg-slate-800 hover:bg-slate-900 text-white font-bold text-xs shadow-sm transition-colors">
                    Terapkan Filter
                </button>
                @if(request()->hasAny(['search', 'status', 'tanggal', 'room_id']))
                    <a href="{{ route('admin.bookings.index') }}" class="py-2 px-3 rounded-xl border border-slate-300 text-slate-600 hover:bg-slate-100 text-xs font-semibold">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table of Bookings -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs font-bold uppercase tracking-wider border-b border-slate-200">
                        <th class="py-3.5 px-6">Peminjam</th>
                        <th class="py-3.5 px-6">Ruangan</th>
                        <th class="py-3.5 px-6">Tanggal & Waktu</th>
                        <th class="py-3.5 px-6">Peserta</th>
                        <th class="py-3.5 px-6">Keperluan</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($bookings as $b)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="py-4 px-6">
                                <div class="font-bold text-slate-900">{{ $b->user->name }}</div>
                                <div class="text-xs text-slate-500">
                                    {{ $b->user->nim_nip ?? $b->user->email }}
                                    @if($b->user->no_hp)
                                        &bull; {{ $b->user->no_hp }}
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-900">{{ $b->room->nama }}</div>
                                <div class="text-xs text-slate-500">{{ $b->room->gedung }} &bull; Lt. {{ $b->room->lantai }}</div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-semibold text-slate-800">{{ \Carbon\Carbon::parse($b->tanggal)->isoFormat('D MMM Y') }}</div>
                                <div class="text-xs font-mono font-medium text-indigo-600">{{ substr($b->jam_mulai, 0, 5) }} - {{ substr($b->jam_selesai, 0, 5) }} WIB</div>
                            </td>
                            <td class="py-4 px-6 text-slate-700">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 text-slate-800">
                                    {{ $b->jumlah_peserta }} / {{ $b->room->kapasitas }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-slate-600 max-w-xs">
                                <p class="text-xs" title="{{ $b->keperluan }}">{{ $b->keperluan }}</p>
                                @if($b->status === 'ditolak' && $b->alasan_penolakan)
                                    <!-- Pure HTML Details Toggle (Zero JS) -->
                                    <details class="mt-1">
                                        <summary class="text-[11px] font-bold text-rose-600 hover:underline cursor-pointer">
                                            Lihat Alasan Ditolak
                                        </summary>
                                        <div class="mt-1 p-2 rounded-lg bg-rose-50 border border-rose-200 text-xs text-rose-800">
                                            {{ $b->alasan_penolakan }}
                                        </div>
                                    </details>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $b->status_badge_class }}">
                                    {{ $b->status_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{ route('admin.bookings.show', $b) }}" class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors" title="Lihat Rincian Lengkap">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    @if($b->status === 'disetujui')
                                        <a href="{{ route('admin.bookings.cetak', $b) }}" target="_blank"
                                            class="p-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition-colors" title="Cetak Surat Izin Peminjaman">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                            </svg>
                                        </a>
                                    @endif

                                    @if($b->status === 'menunggu')
                                        <!-- Approve Button (Pure HTML Form) -->
                                        <form action="{{ route('admin.bookings.approve', $b) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="px-2.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-colors" title="Setujui Booking">
                                                Setujui
                                            </button>
                                        </form>

                                        <!-- Reject Button (Pure HTML link to dedicated reject page) -->
                                        <a href="{{ route('admin.bookings.reject_form', $b) }}"
                                            class="px-2.5 py-1.5 rounded-lg bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 font-bold text-xs transition-colors" title="Tolak dengan Alasan">
                                            Tolak
                                        </a>
                                    @endif

                                    <!-- Delete Button (Pure HTML Form) -->
                                    <form action="{{ route('admin.bookings.destroy', $b) }}" method="POST" onsubmit="return confirm('Hapus riwayat booking ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-slate-100 text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition-colors" title="Hapus Data Booking">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <p class="text-base font-semibold">Tidak ada data pengajuan booking</p>
                                <p class="text-xs mt-1">Coba sesuaikan kriteria filter status atau tanggal.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-200">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection
