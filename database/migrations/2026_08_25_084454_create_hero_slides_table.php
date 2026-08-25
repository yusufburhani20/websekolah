<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("hero_slides", function (Blueprint $table) {
            $table->id();
            $table->string("gambar");
            $table->string("judul")->nullable();
            $table->text("subjudul")->nullable();
            $table->integer("urutan")->default(0);
            $table->enum("aktif", ["ya","tidak"])->default("ya");
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("hero_slides"); }
};