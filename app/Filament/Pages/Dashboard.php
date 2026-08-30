<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Process;
use Illuminate\Contracts\View\View;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected function getHeaderActions(): array
    {
        return [
            Action::make('deploy')
                ->label('Tarik Update (Deploy)')
                ->icon('heroicon-o-cloud-arrow-down')
                ->color('success')
                ->modalHeading('Monitor Deployment')
                ->modalDescription('Proses penarikan kode dan optimasi akan berjalan di server. Jangan tutup jendela ini hingga proses selesai atau halaman dimuat ulang otomatis.')
                ->modalContent(fn (): View => view('filament.pages.deploy-modal'))
                ->modalSubmitActionLabel('Jalankan Deployment Sekarang')
                ->requiresConfirmation()
                ->action(function ($livewire) {
                    $path = base_path('deploy.sh');
                    
                    if (!file_exists($path)) {
                        Notification::make()->title('File deploy.sh tidak ditemukan!')->danger()->send();
                        return;
                    }
                    
                    $livewire->stream('deployLog', "Mempersiapkan server...\n", replace: true);
                    
                    try {
                        $result = Process::timeout(300)->run("bash " . escapeshellarg($path), function (string $type, string $output) use ($livewire) {
                            // Mengirim output baris demi baris secara realtime ke modal
                            $livewire->stream('deployLog', e($output));
                        });
                        
                        if ($result->successful()) {
                            Notification::make()->title('Deployment Selesai & Sukses!')->success()->send();
                            
                            // Beri jeda 1 detik agar pesan sukses terbaca sebelum refresh
                            sleep(1);
                            
                            // Deep refresh halaman
                            return redirect(request()->header('Referer') ?? '/admin');
                        } else {
                            Notification::make()->title('Deployment Gagal atau Terdapat Error!')->danger()->persistent()->send();
                        }
                    } catch (\Exception $e) {
                        Notification::make()->title('Error Eksekusi')->body($e->getMessage())->danger()->send();
                    }
                }),
        ];
    }
}