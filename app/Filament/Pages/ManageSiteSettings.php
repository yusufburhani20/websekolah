<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class ManageSiteSettings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Situs';
    protected static ?string $title = 'Pengaturan Situs';
    protected static ?string $slug = 'pengaturan-situs';
    protected static ?int $navigationSort = 100;
    protected static ?string $navigationGroup = 'Pengaturan';

    protected static string $view = 'filament.pages.manage-site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = SiteSetting::first();
        if ($settings) {
            $data = $settings->toArray();
            // FileUpload with disk public_path expects full relative path from disk root
            foreach (['logo', 'favicon', 'sambutan_foto', 'popup_gambar'] as $field) {
                if (!empty($data[$field])) {
                    // Convert bare filename to full path for FileUpload preview
                    if (!str_contains($data[$field], '/')) {
                        $data[$field] = 'assets/images/' . $data[$field];
                    }
                    $data[$field] = [$data[$field]];
                }
            }
            $this->form->fill($data);
        } else {
            $this->form->fill();
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Pengaturan')
                    ->tabs([

                        Forms\Components\Tabs\Tab::make('Identitas & Kontak')
                            ->icon('heroicon-m-identification')
                            ->schema([
                                Forms\Components\TextInput::make('nama_sekolah')
                                    ->label('Nama Sekolah / Website')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('deskripsi_web')
                                    ->label('Deskripsi Singkat')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo Website')
                                    ->image()
                            ->imageResizeMode('cover')->imageResizeTargetWidth('1920')->imageResizeTargetHeight('1080')
                                    ->disk('public_path')
                                    ->directory('assets/images')
                                    ->helperText('PNG/WebP transparan direkomendasikan'),
                                Forms\Components\FileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->image()
                            ->imageResizeMode('cover')->imageResizeTargetWidth('1920')->imageResizeTargetHeight('1080')
                                    ->disk('public_path')
                                    ->directory('assets/images')
                                    ->helperText('Ikon tab browser (32x32px)'),
                                Forms\Components\TextInput::make('email')
                                    ->label('Email')
                                    ->email(),
                                Forms\Components\TextInput::make('telepon')
                                    ->label('Nomor Telepon'),
                                Forms\Components\Textarea::make('alamat')
                                    ->label('Alamat Lengkap')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('maps_iframe')
                                    ->label('Google Maps Embed (Iframe)')
                                    ->rows(4)
                                    ->columnSpanFull()
                                    ->helperText('Google Maps → Share → Embed a map → salin kode iframe'),
                                Forms\Components\Select::make('tema_warna')
                                    ->label('Tema Warna')
                                    ->options(['blue' => 'Biru', 'red' => 'Merah', 'green' => 'Hijau'])
                                    ->default('blue'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Tampilan Hero')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                Forms\Components\Toggle::make('show_hero_text')
                                    ->label('Tampilkan Teks di Hero Banner')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('hero_judul')
                                    ->label('Judul Utama Hero')
                                    ->columnSpanFull(),
                                Forms\Components\Textarea::make('hero_subjudul')
                                    ->label('Subjudul Hero')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('hero_link_teks')
                                    ->label('Teks Tombol CTA'),
                                Forms\Components\TextInput::make('hero_link')
                                    ->label('URL Tombol CTA'),
                                Forms\Components\Toggle::make('info_sekolah_aktif')
                                    ->label('Aktifkan Info Sekolah (Running Text)'),
                                Forms\Components\TextInput::make('info_sekolah_teks')
                                    ->label('Teks Info Sekolah')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Sosial Media')
                            ->icon('heroicon-m-share')
                            ->schema([
                                Forms\Components\TextInput::make('facebook')->label('Facebook URL'),
                                Forms\Components\TextInput::make('instagram')->label('Instagram URL'),
                                Forms\Components\TextInput::make('youtube')->label('YouTube URL'),
                                Forms\Components\TextInput::make('twitter')->label('Twitter / X URL'),
                                Forms\Components\TextInput::make('tiktok')->label('TikTok URL'),
                                Forms\Components\TextInput::make('whatsapp')->label('WhatsApp (nomor)'),
                                Forms\Components\TextInput::make('telegram')->label('Telegram URL'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Profil & Sambutan')
                            ->icon('heroicon-m-user')
                            ->schema([
                                Forms\Components\Section::make('Profil Sekolah')->schema([
                                    Forms\Components\Toggle::make('show_profil')->label('Tampilkan Seksi Profil'),
                                    Forms\Components\TextInput::make('profil_judul')->label('Judul Profil'),
                                    Forms\Components\Textarea::make('profil_teks')->label('Teks Profil')->rows(4)->columnSpanFull(),
                                    Forms\Components\TextInput::make('profil_link')->label('Link Selengkapnya'),
                                ])->columns(2),
                                Forms\Components\Section::make('Sambutan Kepala Sekolah')->schema([
                                    Forms\Components\Toggle::make('show_sambutan')->label('Tampilkan Seksi Sambutan'),
                                    Forms\Components\TextInput::make('sambutan_nama')->label('Nama Pimpinan'),
                                    Forms\Components\FileUpload::make('sambutan_foto')
                                        ->label('Foto Pimpinan')
                                        ->image()
                            ->imageResizeMode('cover')->imageResizeTargetWidth('1920')->imageResizeTargetHeight('1080')
                                        ->disk('public_path')
                                        ->directory('assets/images'),
                                    Forms\Components\Textarea::make('sambutan_teks')->label('Teks Sambutan')->rows(5)->columnSpanFull(),
                                ])->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Statistik')
                            ->icon('heroicon-m-chart-bar')
                            ->schema([
                                Forms\Components\Toggle::make('show_statistik')->label('Tampilkan Statistik Angka')->columnSpanFull(),
                                Forms\Components\TextInput::make('stat_mahasantri')->label('Jumlah Siswa'),
                                Forms\Components\TextInput::make('stat_dosen')->label('Jumlah Guru/Dosen'),
                                Forms\Components\TextInput::make('stat_alumni')->label('Jumlah Alumni'),
                                Forms\Components\TextInput::make('stat_prodi')->label('Jumlah Prodi/Jurusan'),
                                Forms\Components\Section::make('Grafik')->schema([
                                    Forms\Components\Toggle::make('show_chart')->label('Tampilkan Grafik'),
                                    Forms\Components\TextInput::make('chart_judul')->label('Judul Grafik'),
                                    Forms\Components\TextInput::make('chart_label_1')->label('Label Data 1'),
                                    Forms\Components\TextInput::make('chart_label_2')->label('Label Data 2'),
                                ])->columns(2),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Header & Visibilitas')
                            ->icon('heroicon-m-squares-plus')
                            ->schema([
                                Forms\Components\Section::make('Visibilitas Seksi Beranda')->schema([
                                    Forms\Components\Toggle::make('show_keunggulan')->label('Tampilkan Keunggulan'),
                                    Forms\Components\Toggle::make('show_program')->label('Tampilkan Program'),
                                    Forms\Components\Toggle::make('show_program_utama')->label('Tampilkan Program Utama'),
                                ])->columns(3),
                                Forms\Components\Section::make('Header Pengumuman (Top Bar)')->schema([
                                    Forms\Components\Toggle::make('header_akreditasi_aktif')->label('Aktifkan Teks Kiri'),
                                    Forms\Components\TextInput::make('header_akreditasi_teks')->label('Teks Kiri'),
                                    Forms\Components\TextInput::make('header_akreditasi_url')->label('URL Kiri'),
                                    Forms\Components\Toggle::make('header_pendaftaran_aktif')->label('Aktifkan Tombol Kanan'),
                                    Forms\Components\TextInput::make('header_pendaftaran_teks')->label('Teks Kanan'),
                                    Forms\Components\TextInput::make('header_pendaftaran_url')->label('URL Kanan'),
                                    Forms\Components\Toggle::make('header_pendaftaran_newtab')->label('Buka Tab Baru'),
                                ])->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Pop-up')
                            ->icon('heroicon-m-megaphone')
                            ->schema([
                                Forms\Components\Toggle::make('popup_aktif')->label('Aktifkan Pop-up Beranda')->columnSpanFull(),
                                Forms\Components\FileUpload::make('popup_gambar')
                                    ->label('Gambar Pop-up')
                                    ->image()
                            ->imageResizeMode('cover')->imageResizeTargetWidth('1920')->imageResizeTargetHeight('1080')
                                    ->disk('public_path')
                                    ->directory('assets/images'),
                                Forms\Components\TextInput::make('popup_url')->label('URL tujuan klik'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Sidebar Blog')
                            ->icon('heroicon-m-bars-3-bottom-right')
                            ->schema([
                                Forms\Components\Toggle::make('sidebar_show_sosmed')->label('Tampilkan Widget Sosmed'),
                                Forms\Components\Toggle::make('sidebar_show_artikel')->label('Tampilkan Artikel Terbaru'),
                                Forms\Components\TextInput::make('sidebar_custom_judul')->label('Judul Widget Custom')->columnSpanFull(),
                                Forms\Components\Textarea::make('sidebar_custom_konten')->label('Konten Widget Custom (HTML)')->rows(4)->columnSpanFull(),
                            ])->columns(2),

                    ])->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        // Buang field non-DB
        unset($data['id'], $data['created_at'], $data['updated_at']);

        // FileUpload mengembalikan array - konversi ke string (hanya filename)
        foreach (['logo', 'favicon', 'sambutan_foto', 'popup_gambar'] as $field) {
            if (isset($data[$field]) && is_array($data[$field])) {
                $val = !empty($data[$field]) ? array_values($data[$field])[0] : null;
                // Simpan hanya filename, strip prefix 'assets/images/'
                if ($val) {
                    $val = ltrim(str_replace('assets/images/', '', $val), '/');
                }
                $data[$field] = $val;
            } elseif (isset($data[$field]) && is_string($data[$field])) {
                // Jika sudah string, strip prefix juga
                $data[$field] = ltrim(str_replace('assets/images/', '', $data[$field]), '/');
            }
        }

        // Ganti null dengan string kosong agar tidak melanggar constraint NOT NULL di DB
        foreach ($data as $key => $value) {
            if (is_null($value)) {
                $data[$key] = '';
            }
        }

        try {
            $settings = SiteSetting::first();
            if ($settings) {
                $settings->update($data);
            } else {
                SiteSetting::create($data);
            }

            Notification::make()
                ->success()
                ->title('Pengaturan Berhasil Disimpan')
                ->body('Perubahan sudah aktif di website.')
                ->send();

        } catch (\Throwable $e) {
            Notification::make()
                ->danger()
                ->title('Gagal Menyimpan')
                ->body($e->getMessage())
                ->send();
        }
    }
}
