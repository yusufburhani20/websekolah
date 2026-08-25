<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("lessons", function (Blueprint $table) {
            $table->id();
            $table->foreignId("course_id")->constrained("courses")->cascadeOnDelete();
            $table->string("judul");
            $table->text("deskripsi")->nullable();
            $table->integer("urutan")->default(0);
            $table->date("tanggal")->nullable();
            $table->boolean("aktif")->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("lessons"); }
};