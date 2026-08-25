<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("lesson_materials", function (Blueprint $table) {
            $table->id();
            $table->foreignId("lesson_id")->constrained("lessons")->cascadeOnDelete();
            $table->string("judul");
            $table->enum("tipe", ["file","link","video","text"])->default("file");
            $table->string("file_path")->nullable();
            $table->string("link_url")->nullable();
            $table->longText("konten")->nullable();
            $table->integer("urutan")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("lesson_materials"); }
};