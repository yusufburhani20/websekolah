<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("bk_records", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete();
            $table->string("nama_siswa");
            $table->string("kelas", 20)->nullable();
            $table->string("jenis_layanan", 100);
            $table->text("permasalahan")->nullable();
            $table->text("tindak_lanjut")->nullable();
            $table->enum("status", ["open","closed"])->default("open");
            $table->boolean("rahasia")->default(true);
            $table->date("tanggal")->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("bk_records"); }
};