<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("assignments", function (Blueprint $table) {
            $table->id();
            $table->foreignId("course_id")->constrained("courses")->cascadeOnDelete();
            $table->foreignId("lesson_id")->nullable()->constrained("lessons")->nullOnDelete();
            $table->string("judul");
            $table->longText("deskripsi")->nullable();
            $table->string("file_soal")->nullable();
            $table->datetime("deadline")->nullable();
            $table->integer("nilai_maksimal")->default(100);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("assignments"); }
};