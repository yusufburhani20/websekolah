<?php

namespace App\Filament\Resources\HomeFeatureResource\Pages;

use App\Filament\Resources\HomeFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomeFeatures extends ListRecords
{
    protected static string $resource = HomeFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
