# 📋 Changelog - History Pengembangan

Semua perubahan signifikan pada project ini didokumentasikan di sini.

---

## [1.0.0] - 2026-08-25

### 🎉 Rilis Pertama: Migrasi dari PHP ke Laravel

---

### ✅ Fase 1 - Setup & Fondasi

**Setup awal project Laravel:**
- Inisialisasi project Laravel 13 baru
- Instalasi & konfigurasi Filament v3 sebagai admin panel
- Instalasi Spatie Laravel Permission untuk manajemen role
- Konfigurasi database MySQL & migrasi tabel dari sistem PHP lama
- Implementasi autentikasi (login/logout) dengan halaman login kustom

**Migrasi database:**
- Buat tabel `posts`, `categories`, `tags` untuk berita
- Buat tabel `pages` untuk halaman statis
- Buat tabel `documents` untuk pusat dokumen
- Buat tabel `navigation_menus` untuk menu navigasi
- Buat tabel `site_settings` untuk pengaturan website
- Buat tabel `hero_slides`, `home_features`, `home_programs` untuk konten beranda
- Import data dari database lama menggunakan seeder

---

### ✅ Fase 2 - Modul Manajemen Berita (PostResource)

**Fitur yang dibangun:**
- CRUD berita lengkap (tambah, edit, hapus, lihat)
- Integrasi TinyMCE 6 sebagai rich text editor (tanpa API key, self-hosted)
- Upload thumbnail berita dengan validasi & preview
- Upload foto slider/galeri berita (multiple images)
- Sistem slug otomatis dari judul berita
- Dropdown kategori & pilih tag (multi-select)
- Toggle status publish/draft
- Tombol "Lihat Post" untuk preview di halaman publik
- Redirect otomatis ke daftar berita setelah simpan/batal/hapus

**Bug yang diperbaiki:**
- Teks berita kosong saat edit → diperbaiki dengan konfigurasi TinyMCE yang benar
- Error validasi `thumbnail` tidak bisa dihapus → diperbaiki dengan `nullable()`
- Foto slider tidak muncul di halaman detail → diperbaiki mapping kolom

---

### ✅ Fase 3 - Halaman Statis (PageResource)

**Fitur yang dibangun:**
- CRUD halaman statis lengkap
- Editor TinyMCE untuk konten halaman
- Upload gambar halaman
- Slug otomatis
- Status aktif/nonaktif
- Redirect otomatis setelah aksi

**Bug yang diperbaiki:**
- `MassAssignmentException: Add [judul] to fillable` → ditambahkan `$guarded = []` ke model `Page`
- `Cannot redeclare getHeaderActions()` → dihapus duplikasi method di `EditPage.php`

---

### ✅ Fase 4 - Pusat Dokumen (DocumentResource)

**Fitur yang dibangun:**
- Upload & manajemen dokumen (PDF, DOCX, dll.)
- Kategorisasi dokumen
- Link unduhan publik
- Tabel daftar dengan kolom nama, tipe, tanggal upload

---

### ✅ Fase 5 - Media Library

**Fitur yang dibangun:**
- Galeri terpusat untuk semua gambar yang diupload
- Upload gambar baru ke Media Library
- Gambar dapat dipakai ulang di resource lain (berita, halaman, dll.)
- Selektor gambar "Pilih dari Media Library" di form berita & halaman

---

### ✅ Fase 6 - Menu Navigasi (NavigationMenuResource)

**Fitur yang dibangun:**
- CRUD menu navigasi website
- Pembedaan visual Menu Utama vs Sub Menu:
  - Badge berwarna (Hijau = Utama, Kuning = Sub Menu)
  - Indentasi nama sub menu (`— Sub Menu`)
- Pilih induk menu untuk jadikan sub menu
- Opsi `— Jadikan Menu Utama —` untuk konversi sub menu → menu utama
- Keamanan: tidak bisa pilih diri sendiri sebagai induk (cegah infinite loop)

---

### ✅ Fase 7 - Pengaturan Situs (ManageSiteSettings)

**Fitur yang dibangun:**
- Halaman pengaturan kustom dengan layout Tabs (tabulasi) yang profesional
- **Tab 1 - Identitas & Kontak**: Nama web, Logo, Favicon, Email, Telepon, Alamat, Maps Iframe, Tema Warna
- **Tab 2 - Hero/Banner**: Show/hide teks, Judul, Subjudul, Teks & URL tombol CTA
- **Tab 3 - Sosial Media**: Facebook, Instagram, YouTube, Twitter, TikTok, WhatsApp, Telegram
- **Tab 4 - Profil & Sambutan**: Show/hide profil, Judul, Teks, Link, Nama pimpinan, Foto, Sambutan
- **Tab 5 - Statistik**: Angka siswa/guru/alumni/prodi, Judul & label grafik
- **Tab 6 - Lain-lain**: Toggle visibilitas seksi, Header pengumuman (kiri & kanan), Popup beranda, Sidebar widget

---

### ✅ Fase 8 - Konten Beranda

**HeroSlideResource:**
- CRUD slide gambar carousel/banner beranda
- Upload gambar slide
- Judul, subjudul, urutan tampil

**HomeFeatureResource:**
- CRUD keunggulan/fitur sekolah
- Ikon, judul, deskripsi
- Status aktif

**HomeProgramResource:**
- CRUD program keahlian/jurusan
- Gambar, nama program, deskripsi
- Urutan tampil

---

### ✅ Fase 9 - Penyempurnaan Dashboard

**Perubahan:**
- Sembunyikan widget "Selamat Datang $user" dari beranda dashboard
- Sembunyikan keterangan versi Filament di footer (white-label)
- Sembunyikan footer Filament sepenuhnya via CSS

---

### 🔧 Perbaikan Teknis & Infrastruktur

**Server:**
- Konfigurasi `php -S` dengan router `server.php` kustom yang mengarah ke `public/`
- Peningkatan limit upload: `post_max_size=100M`, `upload_max_filesize=100M`
- Perbaikan `PostTooLargeException` saat upload gambar besar

**Git & Deployment:**
- Inisialisasi repository Git
- Setup SSH key untuk GitHub (tanpa token)
- Push ke repository: github.com/yusufburhani20/websekolah

---

*Dikembangkan oleh tim pengembang bersama AI Assistant Antigravity (Google DeepMind)*
