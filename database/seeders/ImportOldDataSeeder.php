<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ImportOldDataSeeder extends Seeder
{
    // Koneksi ke database lama
    private \PDO $oldDb;

    public function run(): void
    {
        $this->command->info("📦 Memulai import data lama dari database sekolah...");

        try {
            $this->oldDb = new \PDO(
                "mysql:host=127.0.0.1;dbname=sekolah;charset=utf8mb4",
                "sekolah",
                "km5jshR7KfMSnB2p"
            );
            $this->oldDb->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            $this->command->error("❌ Tidak bisa konek ke DB lama: " . $e->getMessage());
            $this->command->warn("💡 Import manual via: php artisan db:seed --class=ImportOldDataSeeder");
            return;
        }

        // Disable FK checks agar truncate tidak error
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->importSiteSettings();
        $this->importJurusans();
        $this->importTeachers();
        $this->importPosts();
        $this->importPostImages();
        $this->importPages();
        $this->importDocuments();
        $this->importMenus();
        $this->importContactMessages();
        $this->importHeroSlides();
        $this->importHomeFeatures();
        $this->importHomePrograms();
        $this->importStudentCharts();

        // Re-enable FK checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info("🎉 Import data lama selesai!");
    }

    private function importSiteSettings(): void
    {
        $old = $this->oldDb->query("SELECT * FROM pengaturan WHERE id = 1 LIMIT 1")->fetch(\PDO::FETCH_ASSOC);
        if (!$old) return;

        DB::table("site_settings")->truncate();
        DB::table("site_settings")->insert([
            "nama_sekolah"              => $old["nama_sekolah"] ?? null,
            "logo"                      => $old["logo"] ?? null,
            "favicon"                   => $old["favicon"] ?? null,
            "alamat"                    => $old["alamat"] ?? null,
            "email"                     => $old["email"] ?? null,
            "telepon"                   => $old["telepon"] ?? null,
            "hero_judul"                => $old["hero_judul"] ?? null,
            "hero_subjudul"             => $old["hero_subjudul"] ?? null,
            "hero_link"                 => $old["hero_link"] ?? "#",
            "hero_link_teks"            => $old["hero_link_teks"] ?? "Info Selengkapnya",
            "show_hero_text"            => $old["show_hero_text"] ?? 1,
            "facebook"                  => $old["facebook"] ?? "",
            "instagram"                 => $old["instagram"] ?? "",
            "youtube"                   => $old["youtube"] ?? "",
            "twitter"                   => $old["twitter"] ?? "",
            "tiktok"                    => $old["tiktok"] ?? "",
            "whatsapp"                  => $old["whatsapp"] ?? "",
            "telegram"                  => $old["telegram"] ?? null,
            "maps_iframe"               => $old["maps_iframe"] ?? null,
            "tema_warna"                => $old["tema_warna"] ?? "blue",
            "header_akreditasi_aktif"   => $old["header_akreditasi_aktif"] ?? 1,
            "header_akreditasi_teks"    => $old["header_akreditasi_teks"] ?? "",
            "header_akreditasi_url"     => $old["header_akreditasi_url"] ?? "",
            "header_pendaftaran_aktif"  => $old["header_pendaftaran_aktif"] ?? 1,
            "header_pendaftaran_newtab" => $old["header_pendaftaran_newtab"] ?? 0,
            "header_pendaftaran_teks"   => $old["header_pendaftaran_teks"] ?? "",
            "header_pendaftaran_url"    => $old["header_pendaftaran_url"] ?? "",
            "show_profil"               => $old["show_profil"] ?? 1,
            "show_sambutan"             => $old["show_sambutan"] ?? 1,
            "show_statistik"            => $old["show_statistik"] ?? 1,
            "show_keunggulan"           => $old["show_keunggulan"] ?? 1,
            "show_program"              => $old["show_program"] ?? 1,
            "show_chart"                => $old["show_chart"] ?? 1,
            "show_program_utama"        => $old["show_program_utama"] ?? 1,
            "profil_judul"              => $old["profil_judul"] ?? null,
            "profil_teks"               => $old["profil_teks"] ?? null,
            "profil_link"               => $old["profil_link"] ?? null,
            "program_judul"             => $old["program_judul"] ?? null,
            "program_teks"              => $old["program_teks"] ?? null,
            "program_link"              => $old["program_link"] ?? null,
            "sambutan_nama"             => $old["sambutan_nama"] ?? null,
            "sambutan_teks"             => $old["sambutan_teks"] ?? null,
            "sambutan_foto"             => $old["sambutan_foto"] ?? null,
            "stat_mahasantri"           => $old["stat_mahasantri"] ?? "0",
            "stat_dosen"                => $old["stat_dosen"] ?? "0",
            "stat_alumni"               => $old["stat_alumni"] ?? "0",
            "stat_prodi"                => $old["stat_prodi"] ?? "0",
            "chart_judul"               => $old["chart_judul"] ?? "Data Siswa Per Tahun",
            "chart_label_1"             => $old["chart_label_1"] ?? "Siswa TKJ",
            "chart_label_2"             => $old["chart_label_2"] ?? "Siswa Akuntansi",
            "sidebar_show_sosmed"       => $old["sidebar_show_sosmed"] ?? 1,
            "sidebar_show_artikel"      => $old["sidebar_show_artikel"] ?? 1,
            "sidebar_custom_judul"      => $old["sidebar_custom_judul"] ?? null,
            "sidebar_custom_konten"     => $old["sidebar_custom_konten"] ?? null,
            "popup_aktif"               => $old["popup_aktif"] ?? 0,
            "popup_gambar"              => $old["popup_gambar"] ?? null,
            "popup_url"                 => $old["popup_url"] ?? null,
            "created_at"                => now(),
            "updated_at"                => now(),
        ]);
        $this->command->info("  ✅ site_settings");
    }

    private function importJurusans(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM jurusan ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("jurusans")->truncate();
        foreach ($rows as $r) {
            DB::table("jurusans")->insert([
                "id"           => $r["id"],
                "nama_jurusan" => $r["nama_jurusan"],
                "singkatan"    => $r["singkatan"],
                "slug"         => Str::slug($r["nama_jurusan"]),
                "deskripsi"    => $r["deskripsi"] ?? null,
                "logo"         => $r["logo"] ?? null,
                "urutan"       => 0,
                "aktif"        => 1,
                "created_at"   => $r["created_at"] ?? now(),
                "updated_at"   => $r["created_at"] ?? now(),
            ]);
        }
        $this->command->info("  ✅ jurusans (" . count($rows) . " baris)");
    }

    private function importTeachers(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM guru ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("teachers")->truncate();
        foreach ($rows as $r) {
            DB::table("teachers")->insert([
                "id"                  => $r["id"],
                "jurusan_id"          => $r["jurusan_id"] ?? null,
                "nama"                => $r["nama"],
                "nidn"                => $r["nidn"] ?? null,
                "jabatan_fungsional"  => $r["jabatan_fungsional"] ?? null,
                "kepakaran"           => $r["kepakaran"] ?? null,
                "jabatan"             => $r["jabatan"] ?? null,
                "bidang"              => $r["bidang"] ?? null,
                "kategori"            => $r["kategori"] ?? "Guru",
                "motto"               => $r["motto"] ?? null,
                "foto"                => $r["foto"] ?? "default-guru.png",
                "urutan"              => 0,
                "aktif"               => 1,
                "created_at"          => $r["created_at"] ?? now(),
                "updated_at"          => $r["created_at"] ?? now(),
            ]);
        }
        $this->command->info("  ✅ teachers (" . count($rows) . " baris)");
    }

    private function importPosts(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM berita ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("posts")->truncate();
        $slugs = [];
        foreach ($rows as $r) {
            $slug = Str::slug($r["judul"]);
            $orig = $slug;
            $i = 1;
            while (in_array($slug, $slugs)) { $slug = $orig . "-" . $i++; }
            $slugs[] = $slug;
            DB::table("posts")->insert([
                "id"               => $r["id"],
                "user_id"          => null,
                "judul"            => $r["judul"],
                "slug"             => $slug,
                "ringkasan"        => $r["ringkasan"] ?? null,
                "isi"              => $r["isi"] ?? null,
                "kategori"         => $r["kategori"] ?? null,
                "foto"             => $r["foto"] ?? null,
                "status"           => "published",
                "tanggal_posting"  => $r["tanggal_posting"] ?? now(),
                "views"            => 0,
                "created_at"       => $r["tanggal_posting"] ?? now(),
                "updated_at"       => $r["tanggal_posting"] ?? now(),
            ]);
        }
        $this->command->info("  ✅ posts (" . count($rows) . " baris)");
    }

    private function importPostImages(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM berita_galeri ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("post_images")->truncate();
        foreach ($rows as $i => $r) {
            DB::table("post_images")->insert([
                "id"         => $r["id"],
                "post_id"    => $r["id_berita"],
                "foto"       => $r["foto"],
                "urutan"     => $i,
                "created_at" => $r["created_at"] ?? now(),
                "updated_at" => $r["created_at"] ?? now(),
            ]);
        }
        $this->command->info("  ✅ post_images (" . count($rows) . " baris)");
    }

    private function importPages(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM halaman ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("pages")->truncate();
        foreach ($rows as $r) {
            DB::table("pages")->insert([
                "id"         => $r["id"],
                "user_id"    => null,
                "judul"      => $r["judul"],
                "slug"       => $r["slug"],
                "konten"     => $r["konten"] ?? null,
                "meta_desc"  => $r["meta_desc"] ?? null,
                "gambar"     => $r["gambar"] ?? null,
                "template"   => $r["template"] ?? "default",
                "status"     => ($r["status"] === "draft") ? "draft" : "published",
                "created_at" => $r["created_at"] ?? now(),
                "updated_at" => $r["updated_at"] ?? now(),
            ]);
        }
        $this->command->info("  ✅ pages (" . count($rows) . " baris)");
    }

    private function importDocuments(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM dokumen ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("documents")->truncate();
        foreach ($rows as $r) {
            DB::table("documents")->insert([
                "id"          => $r["id"],
                "jurusan_id"  => null,
                "judul"       => $r["judul"],
                "kategori"    => $r["kategori"],
                "file_path"   => $r["file_path"],
                "publik"      => 1,
                "created_at"  => $r["tanggal_upload"] ?? now(),
                "updated_at"  => $r["tanggal_upload"] ?? now(),
            ]);
        }
        $this->command->info("  ✅ documents (" . count($rows) . " baris)");
    }

    private function importMenus(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM menu ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("navigation_menus")->truncate();
        foreach ($rows as $r) {
            DB::table("navigation_menus")->insert([
                "id"         => $r["id"],
                "parent_id"  => $r["parent_id"] ?? 0,
                "nama_menu"  => $r["nama_menu"],
                "url"        => $r["url"],
                "urutan"     => $r["urutan"] ?? 0,
                "status"     => $r["status"] ?? "aktif",
                "target"     => $r["target"] ?? "_self",
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
        $this->command->info("  ✅ navigation_menus (" . count($rows) . " baris)");
    }

    private function importContactMessages(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM pesan ORDER BY id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("contact_messages")->truncate();
        foreach ($rows as $r) {
            DB::table("contact_messages")->insert([
                "id"         => $r["id"],
                "nama"       => $r["nama"],
                "email"      => $r["email"],
                "pesan"      => $r["pesan"],
                "status"     => $r["status"] ?? "baru",
                "created_at" => $r["created_at"] ?? now(),
                "updated_at" => $r["created_at"] ?? now(),
            ]);
        }
        $this->command->info("  ✅ contact_messages (" . count($rows) . " baris)");
    }

    private function importHeroSlides(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM hero_galeri ORDER BY urutan ASC, id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("hero_slides")->truncate();
        foreach ($rows as $r) {
            DB::table("hero_slides")->insert([
                "id"         => $r["id"],
                "gambar"     => $r["gambar"] ?? $r["filename"] ?? "",
                "judul"      => null,
                "subjudul"   => null,
                "urutan"     => $r["urutan"] ?? 0,
                "aktif"      => $r["aktif"] ?? "ya",
                "created_at" => $r["created_at"] ?? now(),
                "updated_at" => $r["created_at"] ?? now(),
            ]);
        }
        $this->command->info("  ✅ hero_slides (" . count($rows) . " baris)");
    }

    private function importHomeFeatures(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM home_keunggulan ORDER BY urutan ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("home_features")->truncate();
        foreach ($rows as $r) {
            DB::table("home_features")->insert([
                "id"         => $r["id"],
                "ikon"       => $r["ikon"] ?? "fas fa-star",
                "judul"      => $r["judul"],
                "teks"       => $r["teks"] ?? null,
                "urutan"     => $r["urutan"] ?? 0,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
        $this->command->info("  ✅ home_features (" . count($rows) . " baris)");
    }

    private function importHomePrograms(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM home_program ORDER BY urutan ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("home_programs")->truncate();
        foreach ($rows as $r) {
            DB::table("home_programs")->insert([
                "id"         => $r["id"],
                "ikon"       => $r["ikon"] ?? "fas fa-book",
                "judul"      => $r["judul"],
                "teks"       => $r["teks"] ?? null,
                "link_url"   => $r["link_url"] ?? null,
                "urutan"     => $r["urutan"] ?? 0,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }
        $this->command->info("  ✅ home_programs (" . count($rows) . " baris)");
    }

    private function importStudentCharts(): void
    {
        $rows = $this->oldDb->query("SELECT * FROM siswa_chart ORDER BY urutan ASC, id ASC")->fetchAll(\PDO::FETCH_ASSOC);
        if (empty($rows)) return;
        DB::table("student_charts")->truncate();
        foreach ($rows as $r) {
            DB::table("student_charts")->insert([
                "id"         => $r["id"],
                "tahun"      => $r["tahun"],
                "nilai_1"    => $r["tkj"] ?? $r["mahasantri"] ?? 0,
                "nilai_2"    => $r["akuntansi"] ?? 0,
                "urutan"     => $r["urutan"] ?? 0,
                "created_at" => $r["created_at"] ?? now(),
                "updated_at" => $r["created_at"] ?? now(),
            ]);
        }
        $this->command->info("  ✅ student_charts (" . count($rows) . " baris)");
    }
}
