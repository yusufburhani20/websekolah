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
        Schema::create('tracer_studies', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->text('alamat_lengkap')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('status'); // Bekerja, Kuliah, Wirausaha, Mencari Kerja
            $table->foreignId('jurusan_id')->constrained('jurusans')->onDelete('cascade');
            $table->string('pekerjaan_saat_ini')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->text('alamat_instansi')->nullable();
            $table->string('no_hp')->nullable();
            $table->integer('tahun_masuk');
            $table->integer('tahun_keluar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracer_studies');
    }
};
