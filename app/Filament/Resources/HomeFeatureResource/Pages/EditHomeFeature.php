<?php

namespace App\Filament\Resources\HomeFeatureResource\Pages;

use App\Filament\Resources\HomeFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeFeature extends EditRecord
{
    protected static string $resource = HomeFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
