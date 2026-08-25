<?php

namespace App\Filament\Resources\NavigationMenuResource\Pages;

use App\Filament\Resources\NavigationMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNavigationMenu extends EditRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected static string $resource = NavigationMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
