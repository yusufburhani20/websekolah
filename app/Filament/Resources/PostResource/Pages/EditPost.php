<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('lihat')
                ->label('Lihat Post')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn (): string => url('/berita/' . $this->record->slug))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
        ];
    }
}
