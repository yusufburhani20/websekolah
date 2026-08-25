<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create("navigation_menus", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("parent_id")->default(0);
            $table->string("nama_menu");
            $table->string("url");
            $table->integer("urutan")->default(0);
            $table->enum("status", ["aktif","nonaktif"])->default("aktif");
            $table->enum("target", ["_self","_blank"])->default("_self");
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists("navigation_menus"); }
};