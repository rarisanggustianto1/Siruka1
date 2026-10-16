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
        $rpl = Room::create([
            'kode' => 'LAB-RPL',
            'nama' => 'Laboratorium Rekayasa Perangkat Lunak',
            'gedung' => 'Gedung Ilmu Komputer',
            'lantai' => 2,
            'kapasitas' => 40,
            'deskripsi' => 'Laboratorium untuk pengembangan software, mobile application, web development, dan project riset RPL FMIPA Unila.',
            'status' => 'tersedia',
        ]);
        $rpl->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWhiteboard->id, $fWorkstation->id, $fCctv->id]);

        $jarkom = Room::create([
            'kode' => 'LAB-JARKOM',
            'nama' => 'Laboratorium Jaringan & Keamanan Siber',
            'gedung' => 'Gedung Ilmu Komputer',
            'lantai' => 2,
            'kapasitas' => 35,
            'deskripsi' => 'Fasilitas perangkat jaringan Cisco, server rack, perangkat IoT, dan praktikum computer network & cyber security.',
            'status' => 'tersedia',
        ]);
        $jarkom->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWorkstation->id, $fCctv->id]);

        $dasar = Room::create([
            'kode' => 'LAB-DASAR',
            'nama' => 'Laboratorium Komputer Dasar & Algoritma',
            'gedung' => 'Gedung Ilmu Komputer',
            'lantai' => 1,
            'kapasitas' => 45,
            'deskripsi' => 'Laboratorium utama untuk praktikum Dasar Pemrograman, Struktur Data, dan Algoritma mahasiswa Ilmu Komputer.',
            'status' => 'tersedia',
        ]);
        $dasar->facilities()->attach([$fProyektor->id, $fAc->id, $fWifi->id, $fWhiteboard->id, $fWorkstation->id]);

        $ai = Room::create([
            'kode' => 'LAB-AI',
            'nama' => 'Laboratorium AI & Sains Data',
            'gedung' => 'Gedung Ilmu Komputer',
            'lantai' => 3,
            'kapasitas' => 35,
            'deskripsi' => 'Pusat riset Artificial Intelligence, Machine Learning, Deep Learning, dan Computer Vision FMIPA Unila.',
            'status' => 'tersedia',
        ]);
        $ai->facilities()->attach([$fSmartTv->id, $fAc->id, $fWifi->id, $fWhiteboard->id, $fWorkstation->id, $fCctv->id]);

        $seminar = Room::create([
            'kode' => 'R-SEMINAR',
            'nama' => 'Ruang Seminar Jurusan Ilmu Komputer',
            'gedung' => 'Gedung Ilmu Komputer',
            'lantai' => 3,
            'kapasitas' => 85,
            'deskripsi' => 'Ruangan berkapasitas besar untuk kuliah umum, seminar proposal, workshop teknologi, dan presentasi karya akhir.',
            'status' => 'tersedia',
        ]);
        $seminar->facilities()->attach([$fProyektor->id, $fAc->id, $fSound->id, $fWifi->id, $fWhiteboard->id, $fPodium->id]);

        $sidang = Room::create([
            'kode' => 'R-SIDANG',
            'nama' => 'Ruang Sidang Skripsi Jurusan',
            'gedung' => 'Gedung Ilmu Komputer',
            'lantai' => 1,
            'kapasitas' => 25,
            'deskripsi' => 'Ruang khusus pelaksanaan ujian skripsi, komprehensif, dan rapat pimpinan jurusan Ilmu Komputer.',
            'status' => 'tersedia',
        ]);
        $sidang->facilities()->attach([$fSmartTv->id, $fAc->id, $fWifi->id, $fWhiteboard->id, $fPodium->id]);

        $diskusi = Room::create([
            'kode' => 'R-DISKUSI',
            'nama' => 'Ruang Diskusi & Inkubator Riset Mahasiswa',
            'gedung' => 'Gedung Ilmu Komputer',
            'lantai' => 1,
            'kapasitas' => 20,
            'deskripsi' => 'Ruang santai kolaboratif untuk pengerjaan tugas akhir, bimbingan kelompok riset, dan coding session HIMATRO / HIMAKOM.',
            'status' => 'tersedia',
        ]);
        $diskusi->facilities()->attach([$fAc->id, $fWifi->id, $fWhiteboard->id, $fSmartTv->id]);

        $aula = Room::create([
            'kode' => 'AULA-FMIPA',
            'nama' => 'Aula Dekanat FMIPA Unila',
            'gedung' => 'Gedung Dekanat FMIPA',
            'lantai' => 2,
            'kapasitas' => 250,
            'deskripsi' => 'Aula serbaguna fakultas untuk yudisium, pelantikan organisasi mahasiswa, konferensi internasional, dan dies natalis.',
            'status' => 'tersedia',
        ]);
        $aula->facilities()->attach([$fProyektor->id, $fAc->id, $fSound->id, $fWifi->id, $fPodium->id, $fCctv->id]);

        $maintenanceRoom = Room::create([
            'kode' => 'LAB-MULTIMEDIA',
            'nama' => 'Laboratorium Multimedia & Game Studio',
            'gedung' => 'Gedung Ilmu Komputer',
            'lantai' => 3,
            'kapasitas' => 30,
            'deskripsi' => 'Sedang dilakukan upgrade workstation GPU RTX dan instalasi soundproofing studio audio visual.',
            'status' => 'maintenance',
        ]);
        $maintenanceRoom->facilities()->attach([$fAc->id, $fWifi->id]);

        // 4. Sample Bookings (Hari ini & Mendatang & Riwayat)
        // Booking 1: Hari Ini - Disetujui (Jadwal Terpakai)
        Booking::create([
            'user_id' => $mhs1->id,
            'room_id' => $rpl->id,
            'tanggal' => $today->toDateString(),
            'jam_mulai' => '08:00',
            'jam_selesai' => '11:00',
            'keperluan' => 'Workshop Pengembangan Web Service & API Laravel untuk Mahasiswa Semester 5',
            'jumlah_peserta' => 30,
            'status' => 'disetujui',
            'alasan_penolakan' => null,
        ]);

        // Booking 2: Hari Ini - Disetujui siang hari
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

        // Booking 3: Besok - Status Menunggu (Untuk Pengujian Persetujuan Admin)
        Booking::create([
            'user_id' => $mhs1->id,
            'room_id' => $jarkom->id,
            'tanggal' => $today->copy()->addDay()->toDateString(),
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'keperluan' => 'Simulasi CTF (Capture The Flag) Persiapan Kompetisi Cyber Security Nasional',
            'jumlah_peserta' => 25,
            'status' => 'menunggu',
            'alasan_penolakan' => null,
        ]);

        // Booking 4: 2 Hari lagi - Status Menunggu
        Booking::create([
            'user_id' => $mhs3->id,
            'room_id' => $ai->id,
            'tanggal' => $today->copy()->addDays(2)->toDateString(),
            'jam_mulai' => '10:00',
            'jam_selesai' => '12:30',
            'keperluan' => 'Hands-on Training Fine Tuning Model LLM Open Source',
            'jumlah_peserta' => 28,
            'status' => 'menunggu',
            'alasan_penolakan' => null,
        ]);

        // Booking 5: Ditolak dengan alasan
        Booking::create([
            'user_id' => $mhs2->id,
            'room_id' => $dasar->id,
            'tanggal' => $today->copy()->subDays(2)->toDateString(),
            'jam_mulai' => '08:00',
            'jam_selesai' => '10:00',
            'keperluan' => 'Latihan Mandiri Pemrograman',
            'jumlah_peserta' => 10,
            'status' => 'ditolak',
            'alasan_penolakan' => 'Ruangan pada jam tersebut sudah dijadwalkan untuk Ujian Praktikum Struktur Data reguler.',
        ]);

        // Booking 6: Riwayat Dibatalkan oleh user
        Booking::create([
            'user_id' => $mhs1->id,
            'room_id' => $sidang->id,
            'tanggal' => $today->copy()->subDay()->toDateString(),
            'jam_mulai' => '14:00',
            'jam_selesai' => '16:00',
            'keperluan' => 'Gladi Bersih Presentasi Sidang Tugas Akhir',
            'jumlah_peserta' => 8,
            'status' => 'dibatalkan',
            'alasan_penolakan' => null,
        ]);
    }
}
