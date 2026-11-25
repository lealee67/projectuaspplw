
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_pertandingan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_pertandingan_id')
                ->unique()
                ->constrained('jadwal_pertandingan');
            $table->foreignId('turnamen_id')->constrained('turnamen');
            $table->unsignedInteger('skor_peserta_1');
            $table->unsignedInteger('skor_peserta_2');
            $table->foreignId('pemenang_pendaftaran_id')
                ->constrained('pendaftaran');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_pertandingan');
    }
};
