<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('room_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('nama_kegiatan');
            $table->enum('jenis', ['teori', 'praktikum', 'responsi', 'lainnya'])->default('teori');
            $table->string('kelas')->nullable();
            $table->string('periode')->default('Ganjil 2026/2027');
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            $table->index(['room_id', 'day_of_week', 'aktif']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_schedules');
    }
};
