<?php

namespace App\Filament\Resources\HomeProgramResource\Pages;

use App\Filament\Resources\HomeProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomePrograms extends ListRecords
{
    protected static string $resource = HomeProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
