<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('lihat')
                ->label('Lihat Halaman')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn (): string => url('/halaman/' . $this->record->slug))
                ->openUrlInNewTab(),
            \Filament\Actions\DeleteAction::make(),
        ];
    }
    protected static string $resource = PageResource::class;


}
