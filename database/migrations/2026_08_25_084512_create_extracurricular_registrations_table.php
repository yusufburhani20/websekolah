<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("extracurricular_registrations", function (Blueprint $table) {
            $table->id();
            $table->foreignId("extracurricular_id")->constrained("extracurriculars")->cascadeOnDelete();
            $table->string("nama_siswa");
            $table->string("kelas", 20)->nullable();
            $table->string("no_hp", 20)->nullable();
            $table->string("alasan")->nullable();
            $table->enum("status", ["pending","diterima","ditolak"])->default("pending");
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("extracurricular_registrations"); }
};