<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("ppdb_selections", function (Blueprint $table) {
            $table->id();
            $table->foreignId("ppdb_registration_id")->constrained("ppdb_registrations")->cascadeOnDelete();
            $table->foreignId("jurusan_id")->constrained("jurusans");
            $table->enum("hasil", ["diterima","ditolak","cadangan"]);
            $table->foreignId("diputuskan_oleh")->nullable()->constrained("users")->nullOnDelete();
            $table->text("catatan")->nullable();
            $table->timestamp("diputuskan_at")->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("ppdb_selections"); }
};