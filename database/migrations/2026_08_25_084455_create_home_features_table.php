<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("home_features", function (Blueprint $table) {
            $table->id();
            $table->string("ikon", 100)->default("fas fa-star");
            $table->string("judul");
            $table->text("teks")->nullable();
            $table->integer("urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("home_features"); }
};