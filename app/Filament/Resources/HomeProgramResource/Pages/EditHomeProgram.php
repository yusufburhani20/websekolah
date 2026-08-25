<?php

namespace App\Filament\Resources\HomeProgramResource\Pages;

use App\Filament\Resources\HomeProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomeProgram extends EditRecord
{
    protected static string $resource = HomeProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
