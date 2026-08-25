<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("student_charts", function (Blueprint $table) {
            $table->id();
            $table->string("tahun", 10)->comment("Contoh: 2023/2024");
            $table->integer("nilai_1")->default(0)->comment("Nilai untuk label_1");
            $table->integer("nilai_2")->default(0)->comment("Nilai untuk label_2");
            $table->integer("urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("student_charts"); }
};