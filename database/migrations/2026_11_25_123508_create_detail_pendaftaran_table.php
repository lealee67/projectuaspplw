<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pendaftaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pendaftaran_id')->constrained('pendaftaran');

            $table->string('nama_anggota', 100);
            $table->string('identitas_anggota', 100);
            $table->string('posisi', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pendaftaran');
    }
};
