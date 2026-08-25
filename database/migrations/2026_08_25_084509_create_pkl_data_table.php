<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("pkl_data", function (Blueprint $table) {
            $table->id();
            $table->foreignId("jurusan_id")->nullable()->constrained("jurusans")->nullOnDelete();
            $table->string("nama_tempat");
            $table->text("alamat_tempat")->nullable();
            $table->string("tahun_ajaran", 20);
            $table->date("tanggal_mulai")->nullable();
            $table->date("tanggal_selesai")->nullable();
            $table->integer("jumlah_siswa")->default(0);
            $table->string("pembimbing")->nullable();
            $table->text("deskripsi")->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("pkl_data"); }
};