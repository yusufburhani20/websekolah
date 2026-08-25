<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("students", function (Blueprint $table) {
            $table->id();
            $table->foreignId("jurusan_id")->nullable()->constrained("jurusans")->nullOnDelete();
            $table->string("nis", 20)->unique();
            $table->string("nisn", 20)->nullable();
            $table->string("nama_lengkap");
            $table->string("email")->nullable();
            $table->string("password");
            $table->date("tanggal_lahir")->nullable();
            $table->enum("jenis_kelamin", ["L","P"])->nullable();
            $table->string("kelas", 20)->nullable();
            $table->string("angkatan", 10)->nullable();
            $table->string("foto")->nullable();
            $table->boolean("aktif")->default(true);
            $table->boolean("must_change_password")->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("students"); }
};