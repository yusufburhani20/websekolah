<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("documents", function (Blueprint $table) {
            $table->id();
            $table->foreignId("jurusan_id")->nullable()->constrained("jurusans")->nullOnDelete();
            $table->string("judul");
            $table->string("kategori");
            $table->string("file_path");
            $table->boolean("publik")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("documents"); }
};