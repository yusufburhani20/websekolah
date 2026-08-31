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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->string('judul_lowongan');
            $table->string('posisi');
            $table->text('deskripsi_pekerjaan');
            $table->text('persyaratan');
            $table->enum('tipe_pekerjaan', ['Full-time', 'Part-time', 'Magang/Internship', 'Kontrak']);
            $table->string('lokasi_penempatan');
            $table->date('batas_lamaran');
            $table->boolean('is_active')->default(true);
            $table->json('jurusan_terkait')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
