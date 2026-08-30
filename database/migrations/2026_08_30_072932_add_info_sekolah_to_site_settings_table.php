<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('info_sekolah_aktif')->default(false)->after('show_hero_text');
            $table->string('info_sekolah_teks')->nullable()->after('info_sekolah_aktif');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['info_sekolah_aktif', 'info_sekolah_teks']);
        });
    }
};
