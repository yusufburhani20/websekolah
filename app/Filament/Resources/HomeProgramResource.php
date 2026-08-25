<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomeProgramResource\Pages;
use App\Filament\Resources\HomeProgramResource\RelationManagers;
use App\Models\HomeProgram;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeProgramResource extends Resource
{
    protected static ?string $model = HomeProgram::class;

        protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ikon')
                    ->required()
                    ->maxLength(100)
                    ->default('fas fa-book'),
                Forms\Components\TextInput::make('judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('teks')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('link_url')
                    ->maxLength(255),
                Forms\Components\TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ikon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('link_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListHomePrograms::route('/'),
            'create' => Pages\CreateHomeProgram::route('/create'),
            'edit' => Pages\EditHomeProgram::route('/{record}/edit'),
        ];
    }
}
