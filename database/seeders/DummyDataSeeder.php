<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Site Settings
        DB::table('site_settings')->truncate();
        DB::table('site_settings')->insert([
            'nama_sekolah' => 'Web Sekolah',
            'alamat' => 'Jl. Pendidikan No. 1, Jakarta',
            'email' => 'info@websekolah.local',
            'telepon' => '021-12345678',
            'hero_judul' => 'Selamat Datang di Web Sekolah',
            'hero_subjudul' => 'Membangun Generasi Cerdas dan Berkarakter',
            'profil_judul' => 'Profil Sekolah',
            'profil_teks' => 'Web Sekolah adalah lembaga pendidikan yang berkomitmen untuk memberikan pendidikan terbaik bagi siswa-siswi.',
            'sambutan_nama' => 'Kepala Sekolah',
            'sambutan_teks' => 'Selamat datang di website resmi Web Sekolah.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Navigation Menus
        DB::table('navigation_menus')->truncate();
        DB::table('navigation_menus')->insert([
            ['nama_menu' => 'Beranda', 'url' => '/', 'parent_id' => 0, 'urutan' => 1, 'status' => 'aktif', 'target' => '_self'],
            ['nama_menu' => 'Profil', 'url' => '/profil', 'parent_id' => 0, 'urutan' => 2, 'status' => 'aktif', 'target' => '_self'],
            ['nama_menu' => 'Berita', 'url' => '/berita', 'parent_id' => 0, 'urutan' => 3, 'status' => 'aktif', 'target' => '_self'],
            ['nama_menu' => 'Kontak', 'url' => '/kontak', 'parent_id' => 0, 'urutan' => 4, 'status' => 'aktif', 'target' => '_self'],
        ]);
        
        $this->command->info("🎉 Dummy data (Site Settings & Menus) berhasil diisi!");
    }
}
