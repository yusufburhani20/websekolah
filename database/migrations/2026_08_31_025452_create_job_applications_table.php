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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_vacancy_id')->constrained()->cascadeOnDelete();
            $table->string('nama_pelamar');
            $table->integer('tahun_lulus');
            $table->string('no_hp');
            $table->string('email');
            $table->text('pesan_pengantar')->nullable();
            $table->string('file_cv')->nullable();
            $table->enum('status_lamaran', ['Menunggu', 'Diproses', 'Lolos', 'Ditolak'])->default('Menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
