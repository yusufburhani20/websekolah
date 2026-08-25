<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("pages", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete();
            $table->string("judul");
            $table->string("slug")->unique();
            $table->longText("konten")->nullable();
            $table->text("meta_desc")->nullable();
            $table->string("gambar")->nullable();
            $table->string("template", 50)->default("default");
            $table->enum("status", ["published","draft"])->default("published");
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("pages"); }
};