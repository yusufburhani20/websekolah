<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;

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
            $this->form->fill($settings->toArray());
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
                                Forms\Components\TextInput::make('nama_web')->label('Nama Website')->required(),
                                Forms\Components\Textarea::make('deskripsi_web')->label('Deskripsi Singkat Web')->rows(3),
                                Forms\Components\FileUpload::make('logo')->label('Logo Website')->image()->directory('assets/images'),
                                Forms\Components\FileUpload::make('favicon')->label('Favicon')->image()->directory('assets/images'),
                                Forms\Components\TextInput::make('email')->email(),
                                Forms\Components\TextInput::make('telepon'),
                                Forms\Components\Textarea::make('alamat')->rows(3),
                                Forms\Components\Textarea::make('maps_iframe')->label('Google Maps Iframe')->rows(3),
                                Forms\Components\Select::make('tema_warna')->options(['blue' => 'Blue', 'red' => 'Red', 'green' => 'Green'])->required(),
                            ])->columns(2),
                        
                        Forms\Components\Tabs\Tab::make('Tampilan Utama (Hero)')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                Forms\Components\Toggle::make('show_hero_text')->label('Tampilkan Teks Hero')->default(true),
                                Forms\Components\TextInput::make('hero_judul')->label('Judul Hero'),
                                Forms\Components\Textarea::make('hero_subjudul')->label('Subjudul Hero')->rows(3),
                                Forms\Components\TextInput::make('hero_link_teks')->label('Teks Tombol Hero'),
                                Forms\Components\TextInput::make('hero_link')->label('Link Tombol Hero'),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Sosial Media')
                            ->icon('heroicon-m-share')
                            ->schema([
                                Forms\Components\TextInput::make('facebook')->url(),
                                Forms\Components\TextInput::make('instagram')->url(),
                                Forms\Components\TextInput::make('youtube')->url(),
                                Forms\Components\TextInput::make('twitter')->url(),
                                Forms\Components\TextInput::make('tiktok')->url(),
                                Forms\Components\TextInput::make('whatsapp'),
                                Forms\Components\TextInput::make('telegram')->url(),
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Profil & Sambutan')
                            ->icon('heroicon-m-user')
                            ->schema([
                                Forms\Components\Toggle::make('show_profil')->label('Tampilkan Profil Singkat')->default(true),
                                Forms\Components\TextInput::make('profil_judul')->label('Judul Profil'),
                                Forms\Components\Textarea::make('profil_teks')->label('Teks Profil')->rows(4),
                                Forms\Components\TextInput::make('profil_link')->label('Link Profil'),
                                Forms\Components\Section::make('Sambutan Kepala/Pimpinan')->schema([
                                    Forms\Components\Toggle::make('show_sambutan')->label('Tampilkan Sambutan')->default(true),
                                    Forms\Components\TextInput::make('sambutan_nama')->label('Nama Pimpinan'),
                                    Forms\Components\FileUpload::make('sambutan_foto')->label('Foto Pimpinan')->image()->directory('assets/images'),
                                    Forms\Components\Textarea::make('sambutan_teks')->label('Teks Sambutan')->rows(4),
                                ])->columns(2)
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Statistik')
                            ->icon('heroicon-m-chart-bar')
                            ->schema([
                                Forms\Components\Toggle::make('show_statistik')->label('Tampilkan Statistik')->default(true),
                                Forms\Components\TextInput::make('stat_mahasantri')->label('Jumlah Siswa/Mahasantri'),
                                Forms\Components\TextInput::make('stat_dosen')->label('Jumlah Guru/Dosen'),
                                Forms\Components\TextInput::make('stat_alumni')->label('Jumlah Alumni'),
                                Forms\Components\TextInput::make('stat_prodi')->label('Jumlah Prodi/Jurusan'),
                                Forms\Components\Section::make('Grafik Data')->schema([
                                    Forms\Components\Toggle::make('show_chart')->label('Tampilkan Grafik')->default(true),
                                    Forms\Components\TextInput::make('chart_judul')->label('Judul Grafik'),
                                    Forms\Components\TextInput::make('chart_label_1')->label('Label Grafik 1'),
                                    Forms\Components\TextInput::make('chart_label_2')->label('Label Grafik 2'),
                                ])->columns(2)
                            ])->columns(2),

                        Forms\Components\Tabs\Tab::make('Lain-lain')
                            ->icon('heroicon-m-squares-plus')
                            ->schema([
                                Forms\Components\Toggle::make('show_keunggulan')->label('Tampilkan Keunggulan')->default(true),
                                Forms\Components\Toggle::make('show_program')->label('Tampilkan Program')->default(true),
                                Forms\Components\Toggle::make('show_program_utama')->label('Tampilkan Program Utama')->default(true),
                                Forms\Components\Section::make('Header Pengumuman')->schema([
                                    Forms\Components\Toggle::make('header_akreditasi_aktif')->label('Aktifkan Header Kiri'),
                                    Forms\Components\TextInput::make('header_akreditasi_teks')->label('Teks Kiri'),
                                    Forms\Components\TextInput::make('header_akreditasi_url')->label('URL Kiri'),
                                    Forms\Components\Toggle::make('header_pendaftaran_aktif')->label('Aktifkan Header Kanan'),
                                    Forms\Components\TextInput::make('header_pendaftaran_teks')->label('Teks Kanan'),
                                    Forms\Components\TextInput::make('header_pendaftaran_url')->label('URL Kanan'),
                                    Forms\Components\Toggle::make('header_pendaftaran_newtab')->label('Buka Tab Baru (Header Kanan)'),
                                ])->columns(2),
                                Forms\Components\Section::make('Popup Beranda')->schema([
                                    Forms\Components\Toggle::make('popup_aktif')->label('Aktifkan Popup'),
                                    Forms\Components\FileUpload::make('popup_gambar')->label('Gambar Popup')->image()->directory('assets/images'),
                                    Forms\Components\TextInput::make('popup_url')->label('URL Popup'),
                                ])->columns(2),
                                Forms\Components\Section::make('Sidebar Blog')->schema([
                                    Forms\Components\Toggle::make('sidebar_show_sosmed')->label('Tampilkan Sosmed di Sidebar'),
                                    Forms\Components\Toggle::make('sidebar_show_artikel')->label('Tampilkan Artikel Terbaru'),
                                    Forms\Components\TextInput::make('sidebar_custom_judul')->label('Judul Custom Widget'),
                                    Forms\Components\Textarea::make('sidebar_custom_konten')->label('Konten Custom Widget')->rows(3),
                                ])->columns(2)
                            ])->columns(2),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        try {
            $data = $this->form->getState();
            $settings = SiteSetting::first();
            
            if ($settings) {
                $settings->update($data);
            } else {
                SiteSetting::create($data);
            }

            Notification::make()
                ->success()
                ->title('Berhasil disimpan')
                ->body('Pengaturan situs telah diperbarui.')
                ->send();
                
        } catch (Halt $exception) {
            return;
        }
    }
}
