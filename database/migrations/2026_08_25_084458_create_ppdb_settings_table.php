<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("ppdb_settings", function (Blueprint $table) {
            $table->id();
            $table->string("tahun_ajaran", 20);
            $table->boolean("is_open")->default(false);
            $table->date("tanggal_buka")->nullable();
            $table->date("tanggal_tutup")->nullable();
            $table->integer("kuota_total")->default(0);
            $table->text("persyaratan")->nullable();
            $table->text("jadwal_seleksi")->nullable();
            $table->decimal("biaya_pendaftaran", 10, 2)->default(0);
            $table->string("no_rekening")->nullable();
            $table->string("nama_rekening")->nullable();
            $table->string("bank")->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("ppdb_settings"); }
};