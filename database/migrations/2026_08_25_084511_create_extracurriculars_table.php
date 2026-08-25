<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("extracurriculars", function (Blueprint $table) {
            $table->id();
            $table->string("nama");
            $table->string("slug")->unique();
            $table->text("deskripsi")->nullable();
            $table->string("foto")->nullable();
            $table->string("jadwal")->nullable();
            $table->string("tempat")->nullable();
            $table->string("pembina")->nullable();
            $table->integer("kuota")->nullable();
            $table->boolean("buka_pendaftaran")->default(true);
            $table->boolean("aktif")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("extracurriculars"); }
};