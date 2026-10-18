<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\RoomSchedule;
use Illuminate\Database\Seeder;

class RoomScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $periode = 'Ganjil 2026/2027';

        $jadwal = [

            // GIK-A
            ['GIK-A', 1, '07:30', '09:10', 'Komunikasi Data dan Jaringan Komputer', 'teori', 'D3 MI'],
            ['GIK-A', 1, '09:15', '10:55', 'Rekayasa Perangkat Lunak', 'responsi', 'SIF A'],
            ['GIK-A', 1, '13:55', '15:35', 'Dasar Pemrograman dan Algoritma', 'teori', 'SIF A'],
            ['GIK-A', 1, '15:50', '17:30', 'Dasar Pemrograman dan Algoritma', 'teori', 'SIF B'],
            ['GIK-A', 1, '15:50', '17:30', 'Kapita Selekta (Applied Business Information Systems)', 'teori', 'S1 ILKOM B'],
            ['GIK-A', 2, '07:30', '09:10', 'Kapita Selekta (J)', 'teori', 'S1 ILKOM J'],
            ['GIK-A', 2, '11:00', '12:40', 'Cloud Computing', 'teori', 'SIF SI'],
            ['GIK-A', 2, '13:55', '15:35', 'Agama Islam', 'teori', 'D3 MI'],
            ['GIK-A', 2, '15:50', '17:30', 'Agama Islam', 'responsi', 'D3 MI'],
            ['GIK-A', 3, '07:30', '09:10', 'Kapita Selekta', 'teori', 'S1 ILKOM A'],
            ['GIK-A', 3, '11:00', '12:40', 'Kompleksitas Algoritma', 'responsi', 'ILKOM 2025 B'],
            ['GIK-A', 3, '15:50', '17:30', 'Sistem Basis Data', 'teori', 'SIF A&B'],
            ['GIK-A', 4, '07:30', '09:10', 'Data Mining', 'teori', 'SIF SI'],
            ['GIK-A', 4, '09:15', '10:55', 'Analisis Kota Cerdas', 'teori', 'SIF A&B'],
            ['GIK-A', 4, '11:00', '12:40', 'Filsafat Ilmu', 'teori', 'S2 ILKOM S2'],
            ['GIK-A', 4, '13:55', '15:35', 'Filsafat Ilmu', 'teori', 'S2 ILKOM S2'],
            ['GIK-A', 4, '15:50', '17:30', 'Matematika Komputasi', 'teori', 'D3 MI'],
            ['GIK-A', 5, '07:30', '09:10', 'Penyuntingan Video', 'teori', 'D3 MI'],
            ['GIK-A', 5, '09:15', '10:55', 'Logika', 'responsi', 'D3 MI'],
            ['GIK-A', 5, '15:50', '17:30', 'Rekayasa Perangkat Lunak', 'responsi', 'SIF B'],

            // GIK-B
            ['GIK-B', 1, '07:30', '09:10', 'Pemrograman Web Lanjut', 'teori', 'SIF SI'],
            ['GIK-B', 1, '09:15', '10:55', 'Komputer dan Masyarakat', 'teori', 'S1 ILKOM PIL'],
            ['GIK-B', 1, '11:00', '12:40', 'Pemrograman Mobile Lanjut', 'teori', 'D3 MI'],
            ['GIK-B', 1, '13:55', '15:35', 'Augmented dan Virtual Reality', 'teori', 'S1 ILKOM PIL'],
            ['GIK-B', 1, '15:50', '17:30', 'Augmented dan Virtual Reality', 'responsi', 'S1 ILKOM 2023'],
            ['GIK-B', 2, '07:30', '09:10', 'Kapita Selekta', 'teori', 'S1 ILKOM O'],
            ['GIK-B', 2, '09:15', '10:55', 'Keamanan Sistem Informasi', 'teori', 'SIF SI'],
            ['GIK-B', 2, '11:00', '12:40', 'Pemrograman Berorientasi Objek', 'teori', 'SIF A'],
            ['GIK-B', 2, '13:55', '15:35', 'Pemrograman Berorientasi Objek', 'teori', 'SIF B'],
            ['GIK-B', 2, '15:50', '17:30', 'Kalkulus', 'responsi', 'ILKOM 2026 B'],
            ['GIK-B', 3, '07:30', '09:10', 'Pendidikan Pancasila', 'teori', 'D3 MI'],
            ['GIK-B', 3, '09:15', '10:55', 'Manajemen Proyek Sistem Informasi', 'teori', 'SIF SI'],
            ['GIK-B', 3, '11:00', '12:40', 'Kapita Selekta', 'teori', 'S1 ILKOM K'],
            ['GIK-B', 3, '15:50', '17:30', 'Statistika', 'responsi', 'S1 ILKOM B'],
            ['GIK-B', 4, '07:30', '09:10', 'Dasar-dasar Pemrograman', 'teori', 'D3 MI'],
            ['GIK-B', 4, '09:15', '10:55', 'Pemrograman Berbasis Web', 'teori', 'D3 MI'],
            ['GIK-B', 4, '11:00', '12:40', 'Rekayasa Kebutuhan Perangkat Lunak', 'teori', 'D3 MI'],
            ['GIK-B', 4, '13:55', '15:35', 'Pengantar Pengujian Perangkat Lunak', 'teori', 'D3 MI'],
            ['GIK-B', 5, '07:30', '09:10', 'Teknologi Informasi dan Organisasi Komputer', 'teori', 'D3 MI'],
            ['GIK-B', 5, '09:15', '10:55', 'Pengenalan Pola', 'responsi', 'S1 ILKOM A&B'],
            ['GIK-B', 5, '13:55', '15:35', 'Kalkulus', 'responsi', 'S1 ILKOM A'],

            // GIK-C-LT1
            ['GIK-C-LT1', 1, '07:30', '09:10', 'Pengenalan Pemrograman', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT1', 1, '09:15', '10:55', 'Pengolahan Citra Digital', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT1', 1, '11:00', '12:40', 'Kompleksitas Algoritma', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT1', 1, '13:55', '15:35', 'Sains Dasar', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT1', 1, '15:50', '17:30', 'Pemrograman Terstruktur', 'teori', 'SIF A&B'],
            ['GIK-C-LT1', 2, '09:15', '10:55', 'Pancasila', 'teori', 'ILKOM 2026 B'],
            ['GIK-C-LT1', 2, '11:00', '12:40', 'Sistem Interaksi', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT1', 2, '13:55', '15:35', 'Blockchain dan Crypto Currency', 'teori', 'S1 ILKOM CD'],
            ['GIK-C-LT1', 2, '15:50', '17:30', 'Kewirausahaan', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT1', 3, '07:30', '09:10', 'Pendidikan Agama Islam', 'teori', 'SIF A&B'],
            ['GIK-C-LT1', 3, '09:15', '10:55', 'Pendidikan Agama Islam', 'responsi', 'SIF A&B'],
            ['GIK-C-LT1', 3, '11:00', '12:40', 'Bahasa Inggris', 'teori', 'SIF A&B'],
            ['GIK-C-LT1', 3, '13:55', '15:35', 'Rekayasa Perangkat Lunak', 'teori', 'SIF A&B'],
            ['GIK-C-LT1', 4, '07:30', '09:10', 'Sistem Operasi', 'teori', 'SIF A&B'],
            ['GIK-C-LT1', 4, '09:15', '10:55', 'Penggunaan Generative Artificial Intelligence', 'teori', 'SIF A&B'],
            ['GIK-C-LT1', 4, '11:00', '12:40', 'Pengantar Teknologi Informasi', 'teori', 'SIF A&B'],
            ['GIK-C-LT1', 4, '13:55', '15:35', 'Pengenalan Pola', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT1', 4, '15:50', '17:30', 'Pemrograman Mobile Lanjut', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT1', 5, '07:30', '09:10', 'Bahasa Inggris TI', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT1', 5, '09:15', '10:55', 'Sains Dasar', 'teori', 'SIF A&B'],
            ['GIK-C-LT1', 5, '13:55', '15:35', 'Metodologi Penelitian', 'responsi', 'ILKOM 2024 A&B'],

            // GIK-C-LT2
            ['GIK-C-LT2', 1, '07:30', '09:10', 'Sistem Pakar', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 1, '09:15', '10:55', 'Kalkulus', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 1, '11:00', '12:40', 'Konsep Sistem Informasi', 'teori', 'SIF A&B'],
            ['GIK-C-LT2', 1, '13:55', '15:35', 'Jaringan Komputer', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 1, '15:50', '17:30', 'Penggunaan Generative Artificial Intelligence', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 2, '07:30', '09:10', 'Analisis Kota Cerdas', 'teori', 'SIF SI'],
            ['GIK-C-LT2', 2, '09:15', '10:55', 'Jaringan Komputer dan Komunikasi Data', 'teori', 'SIF A&B'],
            ['GIK-C-LT2', 2, '11:00', '12:40', 'Statistika', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 2, '13:55', '15:35', 'Sistem Operasi', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 2, '15:50', '17:30', 'Manajemen Proses Bisnis', 'teori', 'SIF A&B'],
            ['GIK-C-LT2', 3, '07:30', '09:10', 'Teori Informasi', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 3, '09:15', '10:55', 'Sistem Interaksi', 'responsi', 'S1 ILKOM B'],
            ['GIK-C-LT2', 3, '11:00', '12:40', 'Pemrograman Mobile Lanjut', 'responsi', 'D3 MI'],
            ['GIK-C-LT2', 3, '13:55', '15:35', 'Pengantar Organisasi Komputer', 'teori', 'SIF A&B'],
            ['GIK-C-LT2', 3, '15:50', '17:30', 'Metodologi Penelitian', 'responsi', 'ILKOM 2024 A&B'],
            ['GIK-C-LT2', 4, '07:30', '09:10', 'Logika Matematika', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 4, '09:15', '10:55', 'Pemrograman Berorientasi Objek', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 4, '11:00', '12:40', 'Interaksi Manusia-komputer', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 4, '13:55', '15:35', 'Aplikasi Pengolah Angka', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 4, '15:50', '17:30', 'Kecerdasan Bisnis', 'teori', 'S1 ILKOM A&B'],
            ['GIK-C-LT2', 5, '07:30', '09:10', 'Pemrograman Web Lanjut', 'teori', 'ILKOM 2024 A&B'],
            ['GIK-C-LT2', 5, '13:55', '15:35', 'Logika Matematika', 'teori', 'SIF A&B'],
            ['GIK-C-LT2', 5, '15:50', '17:30', 'Sistem Informasi Geografis', 'responsi', 'SIF SI'],

            // LAB-KD-R1
            ['LAB-KD-R1', 1, '07:30', '09:10', 'Praktikum Pengolahan Citra Digital', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R1', 1, '11:00', '12:40', 'Praktikum Sistem Basis Data', 'praktikum', 'SIF B'],
            ['LAB-KD-R1', 1, '13:55', '15:35', 'Praktikum Pemrograman Web Lanjut', 'praktikum', 'SIF'],
            ['LAB-KD-R1', 1, '15:50', '17:30', 'Praktikum Jaringan Komputer', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R1', 2, '07:30', '09:10', 'Praktikum Basis Data', 'praktikum', 'D3 MI'],
            ['LAB-KD-R1', 2, '09:15', '10:55', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R1', 2, '15:50', '17:30', 'Praktikum Pengenalan Pemrograman', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R1', 3, '07:30', '09:10', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'SIF A'],
            ['LAB-KD-R1', 3, '09:15', '10:55', 'Praktikum Animasi Dasar', 'praktikum', 'D3 MI'],
            ['LAB-KD-R1', 3, '11:00', '12:40', 'Praktikum Sistem Operasi', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R1', 3, '13:55', '15:35', 'Praktikum Dasar-dasar Pemrograman', 'praktikum', 'D3 MI'],
            ['LAB-KD-R1', 4, '07:30', '09:10', 'Praktikum Sistem Operasi', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R1', 4, '09:15', '10:55', 'Praktikum Data Mining', 'praktikum', 'SIF'],
            ['LAB-KD-R1', 4, '11:00', '12:40', 'Praktikum Jaringan Komputer dan Komunikasi Data', 'praktikum', 'SIF B'],
            ['LAB-KD-R1', 4, '13:55', '15:35', 'Praktikum Aplikasi Pengolah Kata dan Presentasi', 'praktikum', 'D3 MI'],
            ['LAB-KD-R1', 4, '15:50', '17:30', 'Praktikum Sistem Operasi', 'praktikum', 'SIF A'],
            ['LAB-KD-R1', 5, '07:30', '09:10', 'Praktikum Pemrograman Terstruktur', 'praktikum', 'SIF B'],
            ['LAB-KD-R1', 5, '09:15', '10:55', 'Praktikum Aplikasi Pengolah Angka', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R1', 5, '13:55', '15:35', 'Praktikum Sistem Operasi', 'praktikum', 'SIF B'],

            // LAB-KD-R2
            ['LAB-KD-R2', 1, '07:30', '09:10', 'Praktikum Pengolahan Citra Digital', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R2', 1, '11:00', '12:40', 'Praktikum Sistem Basis Data', 'praktikum', 'SIF B'],
            ['LAB-KD-R2', 1, '13:55', '15:35', 'Praktikum Pemrograman Web Lanjut', 'praktikum', 'SIF'],
            ['LAB-KD-R2', 1, '15:50', '17:30', 'Praktikum Jaringan Komputer', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R2', 2, '07:30', '09:10', 'Praktikum Basis Data', 'praktikum', 'D3 MI'],
            ['LAB-KD-R2', 2, '09:15', '10:55', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R2', 2, '15:50', '17:30', 'Praktikum Pengenalan Pemrograman', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R2', 3, '07:30', '09:10', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'SIF A'],
            ['LAB-KD-R2', 3, '09:15', '10:55', 'Praktikum Animasi Dasar', 'praktikum', 'D3 MI'],
            ['LAB-KD-R2', 3, '11:00', '12:40', 'Praktikum Sistem Operasi', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R2', 3, '13:55', '15:35', 'Praktikum Dasar-dasar Pemrograman', 'praktikum', 'D3 MI'],
            ['LAB-KD-R2', 4, '07:30', '09:10', 'Praktikum Sistem Operasi', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R2', 4, '09:15', '10:55', 'Praktikum Data Mining', 'praktikum', 'SIF'],
            ['LAB-KD-R2', 4, '11:00', '12:40', 'Praktikum Jaringan Komputer dan Komunikasi Data', 'praktikum', 'SIF B'],
            ['LAB-KD-R2', 4, '13:55', '15:35', 'Praktikum Aplikasi Pengolah Kata dan Presentasi', 'praktikum', 'D3 MI'],
            ['LAB-KD-R2', 4, '15:50', '17:30', 'Praktikum Sistem Operasi', 'praktikum', 'SIF A'],
            ['LAB-KD-R2', 5, '07:30', '09:10', 'Praktikum Pemrograman Terstruktur', 'praktikum', 'SIF B'],
            ['LAB-KD-R2', 5, '09:15', '10:55', 'Praktikum Aplikasi Pengolah Angka', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R2', 5, '13:55', '15:35', 'Praktikum Sistem Operasi', 'praktikum', 'SIF B'],

            // LAB-KD-R3
            ['LAB-KD-R3', 1, '07:30', '09:10', 'Praktikum Pengolahan Citra Digital', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R3', 1, '09:15', '10:55', 'Praktikum Pemrograman Berbasis Web', 'praktikum', 'D3 MI'],
            ['LAB-KD-R3', 1, '13:55', '15:35', 'Praktikum Dasar Pemrograman dan Algoritma', 'praktikum', 'SIF B'],
            ['LAB-KD-R3', 1, '15:50', '17:30', 'Praktikum Aplikasi Pengolah Angka', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R3', 2, '07:30', '09:10', 'Praktikum Jaringan Komputer dan Komunikasi Data', 'praktikum', 'SIF B'],
            ['LAB-KD-R3', 2, '09:15', '10:55', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R3', 2, '13:55', '15:35', 'Praktikum Sistem Pakar', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R3', 2, '15:50', '17:30', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'D3 MI'],
            ['LAB-KD-R3', 3, '07:30', '09:10', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'SIF B'],
            ['LAB-KD-R3', 3, '09:15', '10:55', 'Praktikum Pemrograman Web Lanjut', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R3', 3, '11:00', '12:40', 'Praktikum Pemrograman Web Lanjut', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R3', 3, '13:55', '15:35', 'Praktikum Sistem Pakar', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R3', 3, '15:50', '17:30', 'Praktikum Komunikasi Data dan Jaringan Komputer', 'praktikum', 'D3 MI'],
            ['LAB-KD-R3', 4, '11:00', '12:40', 'Praktikum Pemrograman Terstruktur', 'praktikum', 'SIF A'],
            ['LAB-KD-R3', 4, '13:55', '15:35', 'Praktikum Dasar Pemrograman dan Algoritma', 'praktikum', 'SIF A'],
            ['LAB-KD-R3', 4, '15:50', '17:30', 'Praktikum Jaringan Komputer dan Komunikasi Data', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R3', 5, '09:15', '10:55', 'Praktikum Sistem Basis Data', 'praktikum', 'SIF A'],
            ['LAB-KD-R3', 5, '13:55', '15:35', 'Praktikum Pengenalan Pemrograman', 'praktikum', 'S1 ILKOM B'],

            // LAB-KD-R4
            ['LAB-KD-R4', 1, '07:30', '09:10', 'Praktikum Pengolahan Citra Digital', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R4', 1, '09:15', '10:55', 'Praktikum Pemrograman Berbasis Web', 'praktikum', 'D3 MI'],
            ['LAB-KD-R4', 1, '13:55', '15:35', 'Praktikum Dasar Pemrograman dan Algoritma', 'praktikum', 'SIF B'],
            ['LAB-KD-R4', 1, '15:50', '17:30', 'Praktikum Aplikasi Pengolah Angka', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R4', 2, '07:30', '09:10', 'Praktikum Jaringan Komputer dan Komunikasi Data', 'praktikum', 'SIF B'],
            ['LAB-KD-R4', 2, '09:15', '10:55', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R4', 2, '13:55', '15:35', 'Praktikum Sistem Pakar', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R4', 2, '15:50', '17:30', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'D3 MI'],
            ['LAB-KD-R4', 3, '07:30', '09:10', 'Praktikum Pemrograman Berorientasi Objek', 'praktikum', 'SIF B'],
            ['LAB-KD-R4', 3, '09:15', '10:55', 'Praktikum Pemrograman Web Lanjut', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R4', 3, '11:00', '12:40', 'Praktikum Pemrograman Web Lanjut', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R4', 3, '13:55', '15:35', 'Praktikum Sistem Pakar', 'praktikum', 'S1 ILKOM B'],
            ['LAB-KD-R4', 3, '15:50', '17:30', 'Praktikum Komunikasi Data dan Jaringan Komputer', 'praktikum', 'D3 MI'],
            ['LAB-KD-R4', 4, '11:00', '12:40', 'Praktikum Pemrograman Terstruktur', 'praktikum', 'SIF A'],
            ['LAB-KD-R4', 4, '13:55', '15:35', 'Praktikum Dasar Pemrograman dan Algoritma', 'praktikum', 'SIF A'],
            ['LAB-KD-R4', 4, '15:50', '17:30', 'Praktikum Jaringan Komputer dan Komunikasi Data', 'praktikum', 'S1 ILKOM A'],
            ['LAB-KD-R4', 5, '09:15', '10:55', 'Praktikum Sistem Basis Data', 'praktikum', 'SIF A'],
            ['LAB-KD-R4', 5, '13:55', '15:35', 'Praktikum Pengenalan Pemrograman', 'praktikum', 'S1 ILKOM B'],

            // LAB-RPL
            ['LAB-RPL', 1, '13:55', '15:35', 'Praktikum Penyuntingan Video', 'praktikum', 'D3 MI'],
            ['LAB-RPL', 2, '09:15', '10:55', 'Praktikum Pemrograman Mobile Lanjut', 'praktikum', 'S1 ILKOM A&B'],
            ['LAB-RPL', 3, '15:50', '17:30', 'Praktikum Internet of Things', 'praktikum', 'SIF'],
            ['LAB-RPL', 4, '09:15', '10:55', 'Praktikum Komputasi Paralel', 'praktikum', 'S1 ILKOM PIL'],
            ['LAB-RPL', 5, '09:15', '10:55', 'Praktikum Visualisasi Informasi', 'praktikum', 'D3 MI'],

            // MIPA-T-1A
            ['MIPA-T-1A', 1, '07:30', '09:10', 'Visualisasi Informasi', 'teori', 'D3 MI'],
            ['MIPA-T-1A', 1, '09:15', '10:55', 'Matematika Komputasi', 'teori', 'D3 MI'],
            ['MIPA-T-1A', 1, '11:00', '12:40', 'Cloud Computing', 'teori', 'S1 ILKOM A&B'],
            ['MIPA-T-1A', 2, '07:30', '09:10', 'Agama Islam', 'teori', 'ILKOM 2026 A'],
            ['MIPA-T-1A', 2, '09:15', '10:55', 'Agama Islam', 'responsi', 'ILKOM 2026 A'],
            ['MIPA-T-1A', 2, '11:00', '12:40', 'Animasi Dasar', 'teori', 'D3 MI'],
            ['MIPA-T-1A', 2, '13:55', '15:35', 'Basis Data', 'teori', 'D3 MI'],
            ['MIPA-T-1A', 2, '15:50', '17:30', 'Proyek Khusus', 'teori', 'D3 MI'],
            ['MIPA-T-1A', 3, '07:30', '09:10', 'Agama Islam', 'teori', 'ILKOM 2026 B'],
            ['MIPA-T-1A', 3, '09:15', '10:55', 'Agama Islam', 'responsi', 'ILKOM 2026 B'],
            ['MIPA-T-1A', 3, '11:00', '12:40', 'Manajemen Proses Bisnis', 'teori', 'SISTEM INFORMASI 2025 A'],
            ['MIPA-T-1A', 3, '13:55', '15:35', 'Sistem Interaksi', 'responsi', 'ILKOM 2024 A'],
            ['MIPA-T-1A', 3, '15:50', '17:30', 'Interaksi Manusia-Komputer', 'responsi', 'ILKOM 2025 A'],
            ['MIPA-T-1A', 4, '07:30', '09:10', 'Sistem Informasi Geografis', 'responsi', 'ILKOM 2024 A&B'],
            ['MIPA-T-1A', 4, '09:15', '10:55', 'Cloud Computing', 'responsi', 'S1 ILKOM A&B'],
            ['MIPA-T-1A', 4, '13:55', '15:35', 'Komputasi Paralel', 'teori', 'S1 ILKOM PIL'],
            ['MIPA-T-1A', 4, '15:50', '17:30', 'Manajemen Proses Bisnis', 'responsi', 'SISTEM INFORMASI 2025 B'],
            ['MIPA-T-1A', 5, '09:15', '10:55', 'Statistika', 'responsi', 'S1 ILKOM A'],
            ['MIPA-T-1A', 5, '13:55', '15:35', 'Bahasa Inggris Ii', 'teori', 'D3 MI'],
            ['MIPA-T-1A', 5, '15:50', '17:30', 'Kompleksitas Algoritma', 'responsi', 'ILKOM 2025 A'],

            // MIPA-T-1B
            ['MIPA-T-1B', 1, '07:30', '09:10', 'UI/UX Design', 'teori', 'SIF A&B'],
            ['MIPA-T-1B', 1, '09:15', '10:55', 'Penggunaan Generative Artificial Intelligence', 'teori', 'SIF SI'],
            ['MIPA-T-1B', 1, '13:55', '15:35', 'Sistem Informasi Geografis', 'teori', 'ILKOM 2024 A&B'],
            ['MIPA-T-1B', 1, '15:50', '17:30', 'Logika', 'teori', 'D3 MI'],
            ['MIPA-T-1B', 2, '07:30', '09:10', 'Aplikasi Pengolah Kata dan Presentasi', 'teori', 'D3 MI'],
            ['MIPA-T-1B', 2, '09:15', '10:55', 'Bioinformatika', 'teori', 'S1 ILKOM 2023'],
            ['MIPA-T-1B', 2, '11:00', '12:40', 'Bahasa Inggris Ii', 'teori', 'D3 MI'],
            ['MIPA-T-1B', 2, '13:55', '15:35', 'IOT (Internet untuk Segala)', 'teori', 'SIF SI'],
            ['MIPA-T-1B', 2, '15:50', '17:30', 'Kapita Selekta', 'teori', 'S1 ILKOM I'],
            ['MIPA-T-1B', 3, '07:30', '09:10', 'Cloud Computing', 'responsi', 'SIF SI'],
            ['MIPA-T-1B', 3, '09:15', '10:55', 'Etika Profesi Sistem Informasi', 'teori', 'D3 MI'],
            ['MIPA-T-1B', 3, '11:00', '12:40', 'Kapita Selekta', 'teori', 'S1 ILKOM L'],
            ['MIPA-T-1B', 3, '13:55', '15:35', 'Rekayasa Game', 'teori', 'S1 ILKOM PIL'],
            ['MIPA-T-1B', 3, '15:50', '17:30', 'Kapita Selekta', 'teori', 'S1 ILKOM N'],
            ['MIPA-T-1B', 4, '07:30', '09:10', 'Pemrograman Berorientasi Objek', 'teori', 'D3 MI'],
            ['MIPA-T-1B', 4, '09:15', '10:55', 'Teknik Penulisan Karya Ilmiah', 'teori', 'D3 MI'],
            ['MIPA-T-1B', 4, '11:00', '12:40', 'Pemrosesan Bahasa Alami', 'teori', 'S1 ILKOM A&B'],
            ['MIPA-T-1B', 4, '13:55', '15:35', 'Sistem Informasi Geografis', 'teori', 'SIF SI'],
            ['MIPA-T-1B', 5, '09:15', '10:55', 'Visualisasi dan Story Telling', 'teori', 'SIF SI'],
            ['MIPA-T-1B', 5, '13:55', '15:35', 'Interaksi Manusia-Komputer', 'responsi', 'ILKOM 2025 B'],
            ['MIPA-T-1B', 5, '15:50', '17:30', 'Rekayasa Kebutuhan Perangkat Lunak', 'responsi', 'D3 MI'],
        ];

        $rooms = Room::pluck('id', 'kode');

        foreach ($jadwal as [$kode, $hari, $mulai, $selesai, $kegiatan, $jenis, $kelas]) {
            if (! isset($rooms[$kode])) {
                $this->command?->warn("Ruangan {$kode} tidak ditemukan, dilewati.");
                continue;
            }

            RoomSchedule::updateOrCreate(
                [
                    'room_id' => $rooms[$kode],
                    'day_of_week' => $hari,
                    'jam_mulai' => $mulai,
                    'jam_selesai' => $selesai,
                    'nama_kegiatan' => $kegiatan,
                    'kelas' => $kelas,
                    'periode' => $periode,
                ],
                [
                    'jenis' => $jenis,
                    'aktif' => true,
                ]
            );
        }
    }
}