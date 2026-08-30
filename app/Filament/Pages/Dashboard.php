<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\HtmlString;

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
                        
                        $logOutput = e($result->output());
                        if (empty($logOutput)) {
                            $logOutput = e($result->errorOutput());
                        }

                        $formattedLog = new HtmlString('<div style="margin-top: 10px; max-height: 250px; overflow-y: auto; background: #0f172a; color: #10b981; padding: 12px; border-radius: 8px; font-family: monospace; font-size: 0.75rem; text-align: left; white-space: pre-wrap;">' . $logOutput . '</div>');
                        
                        if ($result->successful()) {
                            Notification::make()
                                ->title('Deployment Berhasil!')
                                ->body($formattedLog)
                                ->success()
                                ->persistent()
                                ->send();
                                
                            // Deep refresh halaman
                            return redirect(request()->header('Referer') ?? '/admin');
                        } else {
                            Notification::make()
                                ->title('Deployment Gagal!')
                                ->body($formattedLog)
                                ->danger()
                                ->persistent()
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