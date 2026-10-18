@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-blue-700">Ringkasan Jurusan</p>
            <h1 class="mt-1 text-2xl sm:text-3xl font-black text-slate-900">Dashboard Admin</h1>
            <p class="mt-1 text-sm text-slate-500">Pantau ruang dan pengajuan peminjaman Ilmu Komputer.</p>
        </div>
        <a href="{{ route('admin.bookings.index') }}" class="siruka-primary-button rounded-xl px-4 py-2.5 text-sm font-bold">Tinjau Pengajuan</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        <article class="admin-stat-card"><p>Total Ruangan</p><strong>{{ $totalRuangan }}</strong><span>Ruangan terdaftar</span></article>
        <article class="admin-stat-card"><p>Total Peminjam</p><strong>{{ $totalPengguna }}</strong><span>Akun pengguna</span></article>
        <article class="admin-stat-card"><p>Menunggu Persetujuan</p><strong>{{ $bookingMenunggu }}</strong><span>Pengajuan perlu ditinjau</span></article>
        <article class="admin-stat-card"><p>Booking Hari Ini</p><strong>{{ $bookingHariIni }}</strong><span>Jadwal peminjaman</span></article>
    </div>

    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 border-b border-slate-200 px-5 py-4">
            <div><h2 class="text-base font-black text-slate-900">Pengajuan Menunggu</h2><p class="text-xs text-slate-500 mt-1">Lima pengajuan terbaru yang perlu ditinjau.</p></div>
            <a href="{{ route('admin.bookings.index') }}" class="text-sm font-bold text-blue-700 hover:text-blue-900">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left border-collapse">
                <thead>
                    <tr class="bg-blue-50/70 border-b border-blue-100">
                        <th class="p-3 text-xs font-bold uppercase tracking-wide text-slate-600">Peminjam</th>
                        <th class="p-3 text-xs font-bold uppercase tracking-wide text-slate-600">Ruangan</th>
                        <th class="p-3 text-xs font-bold uppercase tracking-wide text-slate-600">Tanggal & Jam</th>
                        <th class="p-3 text-xs font-bold uppercase tracking-wide text-slate-600">Keperluan</th>
                        <th class="p-3 text-xs font-bold uppercase tracking-wide text-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $b)
                        <tr class="border-b border-slate-100 hover:bg-blue-50/50">
                            <td class="p-3 text-sm font-semibold text-slate-800">{{ $b->user->name }}<span class="block text-xs font-normal text-slate-500">{{ $b->user->nim_nip ?? '-' }}</span></td>
                            <td class="p-3 text-sm text-slate-700">{{ $b->room->nama }}</td>
                            <td class="p-3 text-sm text-slate-700">{{ \Carbon\Carbon::parse($b->tanggal)->isoFormat('D MMM Y') }}<span class="block text-xs text-slate-500">{{ substr($b->jam_mulai, 0, 5) }}–{{ substr($b->jam_selesai, 0, 5) }} WIB</span></td>
                            <td class="p-3 text-sm text-slate-700">{{ $b->keperluan }}</td>
                            <td class="p-3 text-sm">
                                <a href="{{ route('admin.bookings.show', $b) }}" class="inline-flex rounded-lg border border-blue-200 px-3 py-1.5 font-bold text-blue-700 hover:bg-blue-700 hover:text-white">Tinjau</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-sm text-slate-500">Tidak ada pengajuan yang menunggu persetujuan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
