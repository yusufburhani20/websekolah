<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("ppdb_registrations", function (Blueprint $table) {
            $table->id();
            $table->foreignId("ppdb_setting_id")->constrained("ppdb_settings")->cascadeOnDelete();
            $table->foreignId("jurusan_id_1")->constrained("jurusans");
            $table->foreignId("jurusan_id_2")->nullable()->constrained("jurusans")->nullOnDelete();
            $table->string("nomor_pendaftaran")->unique();
            // Data Diri
            $table->string("nama_lengkap");
            $table->string("nik", 20)->nullable();
            $table->string("nisn", 20)->nullable();
            $table->string("tempat_lahir")->nullable();
            $table->date("tanggal_lahir")->nullable();
            $table->enum("jenis_kelamin", ["L","P"])->nullable();
            $table->string("agama", 20)->nullable();
            $table->text("alamat")->nullable();
            $table->string("no_hp", 20)->nullable();
            $table->string("email")->nullable();
            $table->string("asal_sekolah")->nullable();
            $table->string("npsn_sekolah", 20)->nullable();
            // Data Orang Tua
            $table->string("nama_ayah")->nullable();
            $table->string("pekerjaan_ayah")->nullable();
            $table->string("nama_ibu")->nullable();
            $table->string("pekerjaan_ibu")->nullable();
            $table->string("no_hp_ortu", 20)->nullable();
            $table->text("alamat_ortu")->nullable();
            // Status
            $table->enum("status", ["pending","diproses","diterima","ditolak","cadangan"])->default("pending");
            $table->enum("status_bayar", ["belum_bayar","menunggu_verifikasi","lunas"])->default("belum_bayar");
            $table->text("catatan_admin")->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("ppdb_registrations"); }
};