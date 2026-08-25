<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("curricula", function (Blueprint $table) {
            $table->id();
            $table->foreignId("jurusan_id")->nullable()->constrained("jurusans")->nullOnDelete();
            $table->string("judul");
            $table->string("tahun_ajaran", 20);
            $table->string("kategori", 50)->nullable();
            $table->string("file_path")->nullable();
            $table->text("deskripsi")->nullable();
            $table->boolean("publik")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("curricula"); }
};