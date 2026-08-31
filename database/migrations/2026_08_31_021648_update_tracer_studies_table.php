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
        Schema::table('tracer_studies', function (Blueprint $table) {
            $table->json('status')->change();
            $table->dropColumn(['pekerjaan_saat_ini', 'nama_instansi']);
            $table->string('pekerjaan')->nullable()->after('status');
            $table->string('nama_perusahaan')->nullable()->after('pekerjaan');
            $table->string('kampus')->nullable()->after('nama_perusahaan');
            $table->string('jurusan_kuliah')->nullable()->after('kampus');
            $table->string('bidang_usaha')->nullable()->after('jurusan_kuliah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracer_studies', function (Blueprint $table) {
            // Because rolling back a changed JSON column to string requires Doctrine DBAL,
            // we will just recreate the dropped columns if rolled back.
            $table->string('pekerjaan_saat_ini')->nullable();
            $table->string('nama_instansi')->nullable();
            $table->dropColumn(['pekerjaan', 'nama_perusahaan', 'kampus', 'jurusan_kuliah', 'bidang_usaha']);
        });
    }
};
