@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <section class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <div><h1 class="text-xl font-bold text-slate-900">Kelola Jadwal Ruangan</h1><p class="mt-1 text-sm text-slate-500">Jadwal rutin kuliah memblokir waktu booking pada hari yang sama setiap minggu.</p></div>
        <button type="button" onclick="document.getElementById('schedule-modal').showModal()" class="siruka-primary-button rounded-lg px-4 py-2.5 text-sm font-bold">+ Tambah Jadwal</button>
    </section>
    <dialog id="schedule-modal" class="siruka-modal">
        <div class="siruka-modal__header"><div><h2 class="text-lg font-bold text-slate-900">Tambah Jadwal Ruangan</h2><p class="text-sm text-slate-500">Masukkan jadwal kuliah, praktikum, atau kegiatan rutin.</p></div><button type="button" class="siruka-modal__close" onclick="this.closest('dialog').close()" aria-label="Tutup">&times;</button></div>
        <form action="{{ route('admin.schedules.store') }}" method="POST" class="mt-5 grid gap-3 sm:grid-cols-2">
            @csrf
            <select name="room_id" required class="rounded-lg border-slate-300"><option value="">Pilih ruangan</option>@foreach($rooms as $room)<option value="{{ $room->id }}">{{ $room->nama }}</option>@endforeach</select>
            <select name="day_of_week" required class="rounded-lg border-slate-300"><option value="">Pilih hari</option>@foreach([1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'] as $value=>$day)<option value="{{ $value }}">{{ $day }}</option>@endforeach</select>
            <input type="text" name="nama_kegiatan" required placeholder="Nama mata kuliah / kegiatan" class="rounded-lg border-slate-300">
            <select name="jenis" required class="rounded-lg border-slate-300"><option value="teori">Teori</option><option value="praktikum">Praktikum</option><option value="responsi">Responsi</option><option value="lainnya">Lainnya</option></select>
            <label class="text-xs font-semibold text-slate-600">Jam mulai<input type="time" name="jam_mulai" required class="mt-1 w-full rounded-lg border-slate-300"></label><label class="text-xs font-semibold text-slate-600">Jam selesai<input type="time" name="jam_selesai" required class="mt-1 w-full rounded-lg border-slate-300"></label>
            <input type="text" name="kelas" placeholder="Kelas (opsional)" class="rounded-lg border-slate-300"><input type="text" name="periode" value="Ganjil 2026/2027" required class="rounded-lg border-slate-300">
            <div class="flex justify-end gap-2 sm:col-span-2"><button type="button" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600" onclick="this.closest('dialog').close()">Batal</button><button class="siruka-primary-button rounded-lg px-4 py-2 text-sm font-bold">Simpan Jadwal</button></div>
        </form>
    </dialog>
    <form method="GET" class="schedule-filter flex max-w-xl gap-2"><select name="room_id" class="rounded-lg border-slate-300"><option value="">Semua ruangan</option>@foreach($rooms as $room)<option value="{{ $room->id }}" @selected(request('room_id') == $room->id)>{{ $room->nama }}</option>@endforeach</select><button class="siruka-primary-button rounded-lg px-4 py-2 text-sm font-bold">Cari</button></form>
    <section class="overflow-x-auto rounded-2xl bg-white shadow-sm border border-slate-200">
        <table class="w-full text-left text-sm"><thead class="bg-blue-50 text-blue-900"><tr><th class="p-3">Ruangan</th><th class="p-3">Hari / Jam</th><th class="p-3">Kegiatan</th><th class="p-3">Jenis / Kelas</th><th class="p-3">Periode</th><th class="p-3 text-right">Aksi</th></tr></thead>
            <tbody>
                @forelse($schedules as $schedule)
                    @php($scheduleData = ['id' => $schedule->id, 'room_id' => $schedule->room_id, 'day_of_week' => $schedule->day_of_week, 'jam_mulai' => substr($schedule->jam_mulai, 0, 5), 'jam_selesai' => substr($schedule->jam_selesai, 0, 5), 'nama_kegiatan' => $schedule->nama_kegiatan, 'jenis' => $schedule->jenis, 'kelas' => $schedule->kelas, 'periode' => $schedule->periode])
                    <tr class="border-t"><td class="p-3 font-semibold">{{ $schedule->room->nama }}</td><td class="p-3">{{ [1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'][$schedule->day_of_week] }}<br>{{ substr($schedule->jam_mulai,0,5) }}–{{ substr($schedule->jam_selesai,0,5) }}</td><td class="p-3">{{ $schedule->nama_kegiatan }}</td><td class="p-3">{{ ucfirst($schedule->jenis) }} · {{ $schedule->kelas ?: '—' }}</td><td class="p-3">{{ $schedule->periode }}</td><td class="p-3"><div class="schedule-actions"><button type="button" data-view-schedule="{{ json_encode($scheduleData) }}">Lihat</button><button type="button" data-edit-schedule="{{ json_encode($scheduleData) }}" data-update-url="{{ route('admin.schedules.update', $schedule) }}">Edit</button><form action="{{ route('admin.schedules.destroy', $schedule) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">@csrf @method('DELETE')<button type="submit">Hapus</button></form></div></td></tr>
                @empty
                    <tr><td colspan="6" class="p-6 text-center text-slate-500">Belum ada jadwal.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $schedules->links() }}</div>
    </section>
    <dialog id="schedule-view-modal" class="siruka-modal siruka-modal--small"><div class="siruka-modal__header"><h2 class="text-lg font-bold text-slate-900">Detail Jadwal</h2><button type="button" class="siruka-modal__close" onclick="this.closest('dialog').close()" aria-label="Tutup">&times;</button></div><dl class="inventory-details mt-5 grid grid-cols-2 gap-3 text-sm"><dt>Ruangan</dt><dd data-schedule-detail="room"></dd><dt>Hari</dt><dd data-schedule-detail="day"></dd><dt>Waktu</dt><dd data-schedule-detail="time"></dd><dt>Kegiatan</dt><dd data-schedule-detail="nama_kegiatan"></dd><dt>Jenis</dt><dd data-schedule-detail="jenis"></dd><dt>Kelas</dt><dd data-schedule-detail="kelas"></dd><dt>Periode</dt><dd data-schedule-detail="periode"></dd></dl></dialog>
    <dialog id="schedule-edit-modal" class="siruka-modal"><div class="siruka-modal__header"><h2 class="text-lg font-bold text-slate-900">Edit Jadwal</h2><button type="button" class="siruka-modal__close" onclick="this.closest('dialog').close()" aria-label="Tutup">&times;</button></div><form id="schedule-edit-form" method="POST" class="mt-5 grid gap-3 sm:grid-cols-2">@csrf<input type="hidden" name="_method" value="PUT"><select id="edit-schedule-room" name="room_id" required>@foreach($rooms as $room)<option value="{{ $room->id }}">{{ $room->nama }}</option>@endforeach</select><select id="edit-schedule-day" name="day_of_week" required>@foreach([1=>'Senin',2=>'Selasa',3=>'Rabu',4=>'Kamis',5=>'Jumat',6=>'Sabtu',7=>'Minggu'] as $value=>$day)<option value="{{ $value }}">{{ $day }}</option>@endforeach</select><input id="edit-schedule-name" name="nama_kegiatan" required><select id="edit-schedule-type" name="jenis"><option value="teori">Teori</option><option value="praktikum">Praktikum</option><option value="responsi">Responsi</option><option value="lainnya">Lainnya</option></select><input id="edit-schedule-start" type="time" name="jam_mulai" required><input id="edit-schedule-end" type="time" name="jam_selesai" required><input id="edit-schedule-class" name="kelas" placeholder="Kelas (opsional)"><input id="edit-schedule-period" name="periode" required><div class="flex justify-end gap-2 sm:col-span-2"><button type="button" onclick="this.closest('dialog').close()" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-600">Batal</button><button class="siruka-primary-button rounded-lg px-4 py-2 text-sm font-bold">Simpan Perubahan</button></div></form></dialog>
</div>
<script>
    const scheduleDays = { 1: 'Senin', 2: 'Selasa', 3: 'Rabu', 4: 'Kamis', 5: 'Jumat', 6: 'Sabtu', 7: 'Minggu' };
    document.querySelectorAll('[data-view-schedule]').forEach((button) => button.addEventListener('click', () => {
        const schedule = JSON.parse(button.dataset.viewSchedule);
        const room = button.closest('tr').children[0].textContent.trim();
        const values = { room, day: scheduleDays[schedule.day_of_week], time: `${schedule.jam_mulai}–${schedule.jam_selesai}`, ...schedule };
        Object.entries(values).forEach(([key, value]) => { const output = document.querySelector(`[data-schedule-detail="${key}"]`); if (output) output.textContent = value || '—'; });
        document.getElementById('schedule-view-modal').showModal();
    }));
    document.querySelectorAll('[data-edit-schedule]').forEach((button) => button.addEventListener('click', () => {
        const schedule = JSON.parse(button.dataset.editSchedule);
        document.getElementById('schedule-edit-form').action = button.dataset.updateUrl;
        document.getElementById('edit-schedule-room').value = schedule.room_id;
        document.getElementById('edit-schedule-day').value = schedule.day_of_week;
        document.getElementById('edit-schedule-name').value = schedule.nama_kegiatan;
        document.getElementById('edit-schedule-type').value = schedule.jenis;
        document.getElementById('edit-schedule-start').value = schedule.jam_mulai;
        document.getElementById('edit-schedule-end').value = schedule.jam_selesai;
        document.getElementById('edit-schedule-class').value = schedule.kelas || '';
        document.getElementById('edit-schedule-period').value = schedule.periode;
        document.getElementById('schedule-edit-modal').showModal();
    }));
</script>
@endsection
