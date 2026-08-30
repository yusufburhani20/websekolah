<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // For simplicity and safety, since it's just dummy data, we can drop and recreate the column as JSON,
        // OR we can just use json('gambar')->change() if supported.
        // But SQLite doesn't support dropping columns easily, though Laravel 11 supports it better.
        // Let's assume MySQL is used (or standard DB). We will just change it.
        Schema::table('galleries', function (Blueprint $table) {
            $table->json('gambar')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('gambar')->change();
        });
    }
};
