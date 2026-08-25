<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("jurusans", function (Blueprint $table) {
            $table->id();
            $table->string("nama_jurusan");
            $table->string("singkatan", 20);
            $table->string("slug")->unique();
            $table->text("deskripsi")->nullable();
            $table->string("logo")->nullable();
            $table->integer("urutan")->default(0);
            $table->boolean("aktif")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("jurusans"); }
};