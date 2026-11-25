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
        Schema::create('turnamen', function (Blueprint $table) {
            $table->id();

            // Proteksi hapus master: kategori yang dipakai turnamen tidak bisa dihapus
            $table->foreignId('kategori_kompetisi_id')
                ->constrained('kategori_kompetisi')
                ->restrictOnDelete();

            $table->string('nama_turnamen');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->unsignedInteger('kuota_peserta');
            $table->decimal('biaya_pendaftaran', 12, 2)->default(0);
            $table->string('status')->default('dibuka'); // dibuka / berlangsung / selesai / ditutup
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('turnamen');
    }
};
