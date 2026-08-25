<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("ppdb_documents", function (Blueprint $table) {
            $table->id();
            $table->foreignId("ppdb_registration_id")->constrained("ppdb_registrations")->cascadeOnDelete();
            $table->enum("tipe", ["foto","akta_kelahiran","kartu_keluarga","ijazah","skhun","raport","lainnya"]);
            $table->string("file_path");
            $table->string("keterangan")->nullable();
            $table->boolean("terverifikasi")->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("ppdb_documents"); }
};