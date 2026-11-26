
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_pertandingan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('turnamen_id')->constrained('turnamen');
            $table->foreignId('peserta_1_id')->constrained('pendaftaran');
            $table->foreignId('peserta_2_id')->constrained('pendaftaran');
            $table->foreignId('next_match_id')->nullable()
                ->constrained('jadwal_pertandingan');
            $table->string('next_match_slot', 20)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal_pertandingan');
            $table->time('jam_pertandingan');
            $table->string('mode_pelaksanaan', 20);
            $table->string('lokasi')->nullable();
            $table->string('link_pertandingan')->nullable();
            $table->string('status', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_pertandingan');
    }
};
