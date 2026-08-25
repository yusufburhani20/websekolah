<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("posts", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained()->nullOnDelete();
            $table->string("judul");
            $table->string("slug")->unique();
            $table->text("ringkasan")->nullable();
            $table->longText("isi")->nullable();
            $table->string("kategori", 50)->nullable();
            $table->string("foto")->nullable();
            $table->enum("status", ["published","draft"])->default("published");
            $table->date("tanggal_posting")->nullable();
            $table->unsignedBigInteger("views")->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("posts"); }
};