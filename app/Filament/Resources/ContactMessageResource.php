<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Filament\Resources\ContactMessageResource\RelationManagers;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('pesan')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required(),
                Forms\Components\DateTimePicker::make('replied_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('nama')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable(),
                        Tables\Columns\TextColumn::make('email')
                            ->icon('heroicon-m-envelope')
                            ->color('gray')
                            ->searchable(),
                    ])->space(1),
                    
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('created_at')
                            ->dateTime('d M Y, H:i')
                            ->alignEnd()
                            ->color('gray'),
                        Tables\Columns\TextColumn::make('status')
                            ->badge()
                            ->alignEnd()
                            ->color(fn (string $state): string => match ($state) {
                                'baru' => 'warning',
                                'dibaca' => 'success',
                                'dibalas' => 'primary',
                                default => 'gray',
                            }),
                    ])->space(1),
                ]),
                Tables\Columns\Layout\Panel::make([
                    Tables\Columns\TextColumn::make('pesan')
                        ->wrap(),
                ])->collapsible(false),
            ])
            ->contentGrid([
                'md' => 1,
                'xl' => 1,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('balas')
                    ->label('Balas Email')
                    ->icon('heroicon-m-paper-airplane')
                    ->url(fn (ContactMessage $record): string => 'mailto:' . $record->email . '?subject=Balasan dari Admin SMK Idrisiyyah')
                    ->openUrlInNewTab()
                    ->color('primary'),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
