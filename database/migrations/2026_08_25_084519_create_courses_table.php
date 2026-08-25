<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("courses", function (Blueprint $table) {
            $table->id();
            $table->foreignId("jurusan_id")->nullable()->constrained("jurusans")->nullOnDelete();
            $table->foreignId("teacher_id")->nullable()->constrained("teachers")->nullOnDelete();
            $table->string("nama");
            $table->string("kode", 20)->nullable()->unique();
            $table->text("deskripsi")->nullable();
            $table->string("kelas", 20)->nullable();
            $table->string("tahun_ajaran", 20)->nullable();
            $table->string("semester", 10)->nullable();
            $table->boolean("aktif")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("courses"); }
};