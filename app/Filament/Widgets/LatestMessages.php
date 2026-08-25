<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\ContactMessage;
use Filament\Tables\Columns\TextColumn;

class LatestMessages extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    
    public function table(Table $table): Table
    {
        return $table
            ->query(
                ContactMessage::query()->latest()->limit(5)
            )
            ->columns([
                TextColumn::make('nama')
                    ->label('Pengirim')
                    ->description(fn (ContactMessage $record): string => $record->email)
                    ->weight('bold'),
                TextColumn::make('pesan')
                    ->label('Isi Pesan')
                    ->limit(50)
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Detail')
                    ->icon('heroicon-m-eye')
                    ->url(fn (ContactMessage $record): string => route('filament.admin.resources.contact-messages.index'))
            ])
            ->paginated(false);
    }
}
