<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Process;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('deploy')
                ->label('Tarik Update (Deploy)')
                ->icon('heroicon-o-cloud-arrow-down')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Tarik Update dari GitHub?')
                ->modalDescription('Tindakan ini akan menjalankan script deploy.sh di server untuk mengunduh kode terbaru dari GitHub. Pastikan tidak ada orang yang sedang mengedit sistem saat ini.')
                ->action(function () {
                    // Path ke file deploy.sh di root folder project
                    $path = base_path('deploy.sh');
                    
                    if (!file_exists($path)) {
                        Notification::make()
                            ->title('Gagal: File deploy.sh tidak ditemukan!')
                            ->danger()
                            ->send();
                        return;
                    }
                    
                    try {
                        // Jalankan menggunakan Process facade Laravel
                        $result = Process::timeout(120)->run("bash " . escapeshellarg($path));
                        
                        if ($result->successful()) {
                            Notification::make()
                                ->title('Deployment Berhasil Sukses!')
                                ->body('Semua update telah ditarik dan dioptimasi.')
                                ->success()
                                ->send();
                        } else {
                            Notification::make()
                                ->title('Deployment Gagal!')
                                ->body(substr($result->errorOutput() ?: $result->output(), 0, 200)) // Batasi output jika terlalu panjang
                                ->danger()
                                ->send();
                        }
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error Eksekusi Server')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}