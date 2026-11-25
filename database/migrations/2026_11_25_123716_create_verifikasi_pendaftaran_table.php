<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verifikasi_pendaftaran', function (Blueprint $table) {
            $table->id();

            $table->foreignId('pendaftaran_id')->constrained('pendaftaran');
            $table->foreignId('turnamen_id')->constrained('turnamen');
            $table->foreignId('user_id')->constrained('users');

            $table->string('keputusan', 20);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verifikasi_pendaftaran');
    }
};
