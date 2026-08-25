<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Post;
use Carbon\Carbon;

class PostChart extends ChartWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = 'Tren Artikel Bulanan';

    protected function getData(): array
    {
        $data = [];
        $labels = [];
        
        for ($i = 1; $i <= 12; $i++) {
            $count = Post::whereYear('tanggal_posting', date('Y'))
                         ->whereMonth('tanggal_posting', $i)
                         ->count();
                         
            $data[] = $count;
            $labels[] = Carbon::create()->month($i)->translatedFormat('M');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Artikel',
                    'data' => $data,
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
