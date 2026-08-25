<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Post;
use App\Models\Teacher;
use App\Models\ContactMessage;
use App\Models\Page;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Berita', Post::count())
                ->description('Semua artikel berita')
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('info'),
                
            Stat::make('Total Guru / Staff', Teacher::count())
                ->description('Total tenaga pendidik')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
                
            Stat::make('Pesan Masuk', ContactMessage::count())
                ->description('Pesan belum dibaca')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('warning'),
                
            Stat::make('Halaman Statis', Page::count())
                ->description('Halaman profil sekolah')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),
        ];
    }
}
