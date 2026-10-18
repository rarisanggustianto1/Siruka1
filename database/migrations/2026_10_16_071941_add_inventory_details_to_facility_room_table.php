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
        Schema::table('facility_room', function (Blueprint $table) {
            $table->unsignedInteger('jumlah')->default(1);
            $table->enum('kondisi', ['baik', 'rusak ringan', 'rusak berat', 'perlu perbaikan'])->default('baik');
            $table->text('catatan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('facility_room', function (Blueprint $table) {
            $table->dropColumn(['jumlah', 'kondisi', 'catatan']);
        });
    }
};
