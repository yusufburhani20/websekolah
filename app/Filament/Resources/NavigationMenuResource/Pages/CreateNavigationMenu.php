<?php

namespace App\Filament\Resources\NavigationMenuResource\Pages;

use App\Filament\Resources\NavigationMenuResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateNavigationMenu extends CreateRecord
{
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected static string $resource = NavigationMenuResource::class;
}
