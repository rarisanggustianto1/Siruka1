<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $today = Carbon::today();

        // 1. Users (Admin Jurusan & Mahasiswa/Peminjam)
        $admin = User::create([
            'name' => 'Admin Jurusan Ilmu Komputer',
            'email' => 'admin@siruka.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nim_nip' => '198501012010121001',
            'no_hp' => '081272345678',
        ]);

        $adminUnila = User::create([
            'name' => 'Dr. rer. nat. Akmal Junaidi, S.Si., M.Sc.',
            'email' => 'admin@ilkom.unila.ac.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'nim_nip' => '197004181995121001',
            'no_hp' => '081179012345',
        ]);

        $mhs1 = User::create([
            'name' => 'Alya Zahra Kirana',
            'email' => 'alya@siruka.ac.id',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
            'nim_nip' => '2217051015',
            'no_hp' => '082188776655',
        ]);

        $mhs2 = User::create([
            'name' => 'Raris Anggustianto',
            'email' => 'raris@student.unila.ac.id',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
            'nim_nip' => '2217051042',
            'no_hp' => '085269123456',
        ]);

        $mhs3 = User::create([
            'name' => 'Muhammad Rizky Pratama',
            'email' => 'rizky@student.unila.ac.id',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
            'nim_nip' => '2317051088',
            'no_hp' => '081377889900',
        ]);

        // 2. Master Fasilitas
        $fProyektor = Facility::create(['nama_fasilitas' => 'Proyektor & Screen LCD 4K']);
        $fAc = Facility::create(['nama_fasilitas' => 'AC Split 2 PK Inverter']);
        $fSound = Facility::create(['nama_fasilitas' => 'Sound System & Mic Wireless']);
        $fWifi = Facility::create(['nama_fasilitas' => 'High Speed WiFi 1 Gbps']);
        $fWhiteboard = Facility::create(['nama_fasilitas' => 'Glass Whiteboard & Marker']);
        $fSmartTv = Facility::create(['nama_fasilitas' => 'Smart Interactive TV 75 Inch']);
        $fWorkstation = Facility::create(['nama_fasilitas' => 'Workstation PC Core i7 & RTX 4060']);
        $fPodium = Facility::create(['nama_fasilitas' => 'Podium Presentasi & Pointer']);
        $fCctv = Facility::create(['nama_fasilitas' => 'CCTV 24 Jam & RFID Access']);

        // 3. Master Ruangan Jurusan Ilmu Komputer FMIPA Unila
        // GIK C Lt. 1
        $gikC1 = Room::create([
            'kode' => 'GIK-C-LT1',
            'nama' => 'GIK C Lt. 1',
            'gedung' => 'Gedung Ilmu Komputer (GIK) C',
            'lantai' => 1,
            'kapasitas' => 45,
            'deskripsi' => 'Ruang kuliah di lantai 1 Gedung Ilmu Komputer C. Dilengkapi proyektor dan AC, cocok untuk kuliah reguler dan tutorial.',
            'status' => 'tersedia',
        ]);
        $gikC1->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWhiteboard->id]);

        // GIK C Lt. 2
        $gikC2 = Room::create([
            'kode' => 'GIK-C-LT2',
            'nama' => 'GIK C Lt. 2',
            'gedung' => 'Gedung Ilmu Komputer (GIK) C',
            'lantai' => 2,
            'kapasitas' => 45,
            'deskripsi' => 'Ruang kuliah di lantai 2 Gedung Ilmu Komputer C. Dilengkapi fasilitas multimedia modern untuk kegiatan pembelajaran.',
            'status' => 'tersedia',
        ]);
        $gikC2->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWhiteboard->id, $fSmartTv->id]);

        // GIK A
        $gikA = Room::create([
            'kode' => 'GIK-A',
            'nama' => 'GIK A',
            'gedung' => 'Gedung Ilmu Komputer (GIK) A',
            'lantai' => 1,
            'kapasitas' => 60,
            'deskripsi' => 'Ruang kuliah besar di Gedung Ilmu Komputer A. Kapasitas lebih besar, ideal untuk kuliah bersama dan kelas besar.',
            'status' => 'tersedia',
        ]);
        $gikA->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWhiteboard->id, $fSound->id]);

        // GIK B
        $gikB = Room::create([
            'kode' => 'GIK-B',
            'nama' => 'GIK B',
            'gedung' => 'Gedung Ilmu Komputer (GIK) B',
            'lantai' => 1,
            'kapasitas' => 50,
            'deskripsi' => 'Ruang kuliah di Gedung Ilmu Komputer B. Fasilitas lengkap untuk kegiatan perkuliahan, seminar kecil, dan diskusi kelompok.',
            'status' => 'tersedia',
        ]);
        $gikB->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWhiteboard->id]);

        // Ruang Seminar
        $seminar = Room::create([
            'kode' => 'R-SEMINAR',
            'nama' => 'Ruang Seminar',
            'gedung' => 'Gedung Ilmu Komputer (GIK)',
            'lantai' => 3,
            'kapasitas' => 100,
            'deskripsi' => 'Ruang seminar berkapasitas besar untuk kuliah umum, workshop teknologi, seminar proposal, dan presentasi karya akhir mahasiswa Ilmu Komputer.',
            'status' => 'tersedia',
        ]);
        $seminar->facilities()->attach([$fProyektor->id, $fAc->id, $fSound->id, $fWifi->id, $fWhiteboard->id, $fPodium->id]);

        // Ruang Baca
        $baca = Room::create([
            'kode' => 'R-BACA',
            'nama' => 'Ruang Baca',
            'gedung' => 'Gedung Ilmu Komputer (GIK)',
            'lantai' => 2,
            'kapasitas' => 30,
            'deskripsi' => 'Ruang baca dan diskusi tenang untuk mahasiswa. Tersedia koleksi buku referensi, jurnal, dan area belajar mandiri yang kondusif.',
            'status' => 'tersedia',
        ]);
        $baca->facilities()->attach([$fAc->id, $fWifi->id, $fSmartTv->id]);

        // MIPA T Lt 1 A
        $mipaTA = Room::create([
            'kode' => 'MIPA-T-1A',
            'nama' => 'MIPA T Lt 1 A',
            'gedung' => 'Gedung MIPA Terpadu (MIPA T)',
            'lantai' => 1,
            'kapasitas' => 50,
            'deskripsi' => 'Ruang kuliah di lantai 1 Gedung MIPA Terpadu sayap A. Digunakan untuk mata kuliah matematika, fisika, dan sains dasar bersama.',
            'status' => 'tersedia',
        ]);
        $mipaTA->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWhiteboard->id]);

        // MIPA T Lt 1 B
        $mipaTB = Room::create([
            'kode' => 'MIPA-T-1B',
            'nama' => 'MIPA T Lt 1 B',
            'gedung' => 'Gedung MIPA Terpadu (MIPA T)',
            'lantai' => 1,
            'kapasitas' => 50,
            'deskripsi' => 'Ruang kuliah di lantai 1 Gedung MIPA Terpadu sayap B. Fasilitas lengkap untuk perkuliahan bersama lintas jurusan FMIPA.',
            'status' => 'tersedia',
        ]);
        $mipaTB->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWhiteboard->id]);

        // Lab RPL
        $labRpl = Room::create([
            'kode' => 'LAB-RPL',
            'nama' => 'Lab RPL',
            'gedung' => 'Gedung Ilmu Komputer (GIK)',
            'lantai' => 2,
            'kapasitas' => 40,
            'deskripsi' => 'Laboratorium Rekayasa Perangkat Lunak. Dilengkapi workstation untuk pengembangan software, mobile application, web development, dan project riset RPL.',
            'status' => 'tersedia',
        ]);
        $labRpl->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWhiteboard->id, $fWorkstation->id, $fCctv->id]);

        // LAB KD R1
        $labKdR1 = Room::create([
            'kode' => 'LAB-KD-R1',
            'nama' => 'LAB Komputasi Dasar (KD) R1',
            'gedung' => 'Gedung Ilmu Komputer (GIK)',
            'lantai' => 1,
            'kapasitas' => 40,
            'deskripsi' => 'Laboratorium Komputasi Dasar Ruang 1. Tempat praktikum Dasar Pemrograman, Algoritma, dan Pemrograman Terstruktur bagi mahasiswa baru.',
            'status' => 'tersedia',
        ]);
        $labKdR1->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWorkstation->id]);

        // LAB KD R2
        $labKdR2 = Room::create([
            'kode' => 'LAB-KD-R2',
            'nama' => 'LAB Komputasi Dasar (KD) R2',
            'gedung' => 'Gedung Ilmu Komputer (GIK)',
            'lantai' => 1,
            'kapasitas' => 40,
            'deskripsi' => 'Laboratorium Komputasi Dasar Ruang 2. Mendukung praktikum Struktur Data, Algoritma Lanjut, dan pemrograman berbasis objek.',
            'status' => 'tersedia',
        ]);
        $labKdR2->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWorkstation->id]);

        // LAB KD R3
        $labKdR3 = Room::create([
            'kode' => 'LAB-KD-R3',
            'nama' => 'LAB Komputasi Dasar (KD) R3',
            'gedung' => 'Gedung Ilmu Komputer (GIK)',
            'lantai' => 1,
            'kapasitas' => 40,
            'deskripsi' => 'Laboratorium Komputasi Dasar Ruang 3. Digunakan untuk praktikum Basis Data, Pemrograman Web, dan kelas komputer reguler.',
            'status' => 'tersedia',
        ]);
        $labKdR3->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWorkstation->id, $fWhiteboard->id]);

        // LAB KD R4
        $labKdR4 = Room::create([
            'kode' => 'LAB-KD-R4',
            'nama' => 'LAB Komputasi Dasar (KD) R4',
            'gedung' => 'Gedung Ilmu Komputer (GIK)',
            'lantai' => 1,
            'kapasitas' => 40,
            'deskripsi' => 'Laboratorium Komputasi Dasar Ruang 4. Fasilitas komputer untuk praktikum Jaringan Komputer, Sistem Operasi, dan pemrograman sistem.',
            'status' => 'maintenance',
        ]);
        $labKdR4->facilities()->attach([$fAc->id, $fWifi->id]);

        // 4. Sample Bookings (Hari ini & Mendatang & Riwayat)
        Booking::create([
            'user_id' => $mhs1->id,
            'room_id' => $labRpl->id,
            'tanggal' => $today->toDateString(),
            'jam_mulai' => '08:00',
            'jam_selesai' => '11:00',
            'keperluan' => 'Workshop Pengembangan Web Service & API Laravel untuk Mahasiswa Semester 5',
            'jumlah_peserta' => 30,
            'status' => 'disetujui',
            'alasan_penolakan' => null,
        ]);

        Booking::create([
            'user_id' => $mhs2->id,
            'room_id' => $seminar->id,
            'tanggal' => $today->toDateString(),
            'jam_mulai' => '13:00',
            'jam_selesai' => '16:00',
            'keperluan' => 'Seminar Teknologi Cloud Computing & DevSecOps bersama Guest Lecturer',
            'jumlah_peserta' => 65,
            'status' => 'disetujui',
            'alasan_penolakan' => null,
        ]);

        Booking::create([
            'user_id' => $mhs1->id,
            'room_id' => $gikA->id,
            'tanggal' => $today->copy()->addDay()->toDateString(),
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'keperluan' => 'Simulasi CTF (Capture The Flag) Persiapan Kompetisi Cyber Security Nasional',
            'jumlah_peserta' => 50,
            'status' => 'menunggu',
            'alasan_penolakan' => null,
        ]);

        Booking::create([
            'user_id' => $mhs3->id,
            'room_id' => $labKdR1->id,
            'tanggal' => $today->copy()->addDays(2)->toDateString(),
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:30',
            'keperluan' => 'Hands-on Training Fine Tuning Model LLM Open Source',
            'jumlah_peserta' => 35,
            'status' => 'menunggu',
            'alasan_penolakan' => null,
        ]);

        Booking::create([
            'user_id' => $mhs2->id,
            'room_id' => $gikC1->id,
            'tanggal' => $today->copy()->subDays(2)->toDateString(),
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'keperluan' => 'Latihan Mandiri Pemrograman',
            'jumlah_peserta' => 10,
            'status' => 'ditolak',
            'alasan_penolakan' => 'Ruangan pada jam tersebut sudah dijadwalkan untuk Ujian Praktikum Struktur Data reguler.',
        ]);

        Booking::create([
            'user_id' => $mhs1->id,
            'room_id' => $baca->id,
            'tanggal' => $today->copy()->subDay()->toDateString(),
            'jam_mulai' => '14:00',
            'jam_selesai' => '16:00',
            'keperluan' => 'Diskusi Kelompok Tugas Akhir',
            'jumlah_peserta' => 8,
            'status' => 'dibatalkan',
            'alasan_penolakan' => null,
        ]);
    }
}
