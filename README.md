# 🏫 Web Sekolah SMK Idrisiyyah - Laravel CMS

Sistem manajemen konten (CMS) website resmi **SMK Idrisiyyah** yang dibangun menggunakan **Laravel 13** dengan panel admin **Filament v3**.

## 🛠️ Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Framework | Laravel 13.26.1 |
| PHP | 8.3.33 |
| Admin Panel | Filament v3 |
| Database | MySQL |
| Auth & Roles | Spatie Laravel Permission |
| Rich Text Editor | TinyMCE 6 |
| Frontend | Blade + Vanilla CSS |

---

## ✨ Fitur Utama

### 📰 Manajemen Berita / Post
- Tambah, edit, hapus berita
- Upload thumbnail & foto slider berita
- Editor teks kaya (TinyMCE) untuk konten berita
- Pilih kategori & tag
- Status publish/draft
- Tombol "Lihat Post" untuk preview langsung

### 📄 Halaman Statis
- Kelola halaman statis (Profil, Visi Misi, Kontak, dll.)
- Editor TinyMCE untuk konten halaman
- Redirect otomatis ke daftar setelah simpan/batal/hapus

### 🖼️ Media Library
- Pusat penyimpanan gambar terpusat
- Upload gambar ke sistem
- Gambar di Media Library dapat dipakai ulang di berita & halaman statis
- Tampilan grid/galeri

### 🗂️ Dokumen Center
- Upload & kelola dokumen (PDF, DOCX, dll.)
- Kategorisasi dokumen
- Link unduhan publik

### 🧭 Menu Navigasi
- Kelola menu navigasi website
- Bedakan Menu Utama & Sub Menu secara visual (badge berwarna)
- Pengaturan mudah: pilih induk menu untuk jadikan sub menu

### ⚙️ Pengaturan Situs (Bertab)
Pengaturan lengkap website dalam form tab yang rapi:
- **Identitas & Kontak**: Nama web, Logo, Favicon, Email, Alamat, Telepon, Maps
- **Hero/Banner**: Teks utama, subjudul, tombol CTA
- **Sosial Media**: Facebook, Instagram, YouTube, TikTok, Twitter, WhatsApp, Telegram
- **Profil & Sambutan**: Teks profil sekolah, foto & sambutan kepala sekolah
- **Statistik**: Jumlah siswa, guru, alumni, prodi
- **Grafik Data**: Konfigurasi grafik perkembangan siswa
- **Header Pengumuman**: Teks akreditasi & pendaftaran di header
- **Pop-up Beranda**: Gambar promo/pengumuman popup
- **Sidebar Blog**: Widget sosmed & artikel di sidebar

### 🖼️ Konten Beranda
- **Hero Slide**: Kelola gambar carousel/slider beranda
- **Keunggulan (Home Feature)**: Fitur/keunggulan sekolah dengan ikon
- **Program Keahlian**: Daftar jurusan yang tersedia

### 🔐 Autentikasi & Roles
- Login admin yang aman
- Manajemen role & permission (via Spatie)
- Halaman login kustom

---

## 🚀 Instalasi

```bash
# Clone repository
git clone git@github.com:yusufburhani20/websekolah.git
cd websekolah

# Install dependencies
composer install

# Copy & konfigurasi .env
cp .env.example .env
php artisan key:generate

# Konfigurasi database di .env lalu jalankan migrasi
php artisan migrate --seed

# Jalankan server
php artisan serve
```

**Akses Admin Panel:** `http://localhost:8000/admin`

---

## 📁 Struktur Direktori Penting

```
app/
├── Filament/
│   ├── Pages/
│   │   ├── Auth/Login.php          # Halaman login kustom
│   │   └── ManageSiteSettings.php  # Pengaturan situs (tab)
│   ├── Resources/
│   │   ├── PostResource.php        # Manajemen berita
│   │   ├── PageResource.php        # Halaman statis
│   │   ├── DocumentResource.php    # Dokumen center
│   │   ├── MediaLibraryResource.php# Media library
│   │   ├── NavigationMenuResource.php # Menu navigasi
│   │   ├── HeroSlideResource.php   # Slide beranda
│   │   ├── HomeFeatureResource.php # Keunggulan beranda
│   │   └── HomeProgramResource.php # Program keahlian
│   └── Widgets/                    # Dashboard widgets
├── Models/
│   ├── Post.php
│   ├── Page.php
│   ├── Document.php
│   ├── NavigationMenu.php
│   ├── SiteSetting.php
│   ├── HeroSlide.php
│   ├── HomeFeature.php
│   └── HomeProgram.php
public/
└── assets/images/                  # Penyimpanan gambar
resources/views/
├── filament/                       # View kustom Filament
└── layouts/public.blade.php        # Layout website publik
```

---

## 📝 Lisensi

Dikembangkan untuk keperluan internal **SMK Idrisiyyah**.
