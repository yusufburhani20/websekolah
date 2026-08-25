<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("teachers", function (Blueprint $table) {
            $table->id();
            $table->foreignId("jurusan_id")->nullable()->constrained("jurusans")->nullOnDelete();
            $table->string("nama");
            $table->string("nidn", 50)->nullable();
            $table->string("jabatan_fungsional")->nullable();
            $table->string("kepakaran")->nullable();
            $table->string("jabatan")->nullable();
            $table->string("bidang")->nullable();
            $table->string("kategori")->default("Guru");
            $table->text("motto")->nullable();
            $table->string("foto")->default("default-guru.png");
            $table->integer("urutan")->default(0);
            $table->boolean("aktif")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("teachers"); }
};