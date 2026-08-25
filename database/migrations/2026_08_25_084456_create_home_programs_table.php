<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("home_programs", function (Blueprint $table) {
            $table->id();
            $table->string("ikon", 100)->default("fas fa-book");
            $table->string("judul");
            $table->text("teks")->nullable();
            $table->string("link_url")->nullable();
            $table->integer("urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("home_programs"); }
};