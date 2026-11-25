<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * T5: penetapan_juara
     * Bergantung pada: turnamen, pendaftaran, users (harus dimigrasi lebih dulu).
     * Ini migration TERAKHIR dalam urutan.
     */
    public function up(): void
    {
        Schema::create('penetapan_juara', function (Blueprint $table) {
            $table->id();

            $table->foreignId('turnamen_id')->constrained('turnamen')->restrictOnDelete();
            $table->foreignId('pendaftaran_id')->constrained('pendaftaran')->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete(); // panitia

            $table->unsignedInteger('peringkat');
            $table->timestamp('created_at')->useCurrent();

            // Satu peringkat hanya untuk satu peserta per turnamen,
            // dan satu peserta hanya boleh punya satu peringkat per turnamen
            $table->unique(['turnamen_id', 'peringkat']);
            $table->unique(['turnamen_id', 'pendaftaran_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penetapan_juara');
    }
};
