<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("grades", function (Blueprint $table) {
            $table->id();
            $table->foreignId("course_id")->constrained("courses")->cascadeOnDelete();
            $table->foreignId("student_id")->constrained("students")->cascadeOnDelete();
            $table->decimal("nilai_tugas", 5, 2)->nullable();
            $table->decimal("nilai_uts", 5, 2)->nullable();
            $table->decimal("nilai_uas", 5, 2)->nullable();
            $table->decimal("nilai_akhir", 5, 2)->nullable();
            $table->string("predikat", 5)->nullable();
            $table->text("catatan")->nullable();
            $table->unique(["course_id","student_id"]);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("grades"); }
};