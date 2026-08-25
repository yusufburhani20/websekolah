<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jurusan_id')
                    ->numeric(),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nidn')
                    ->maxLength(50),
                Forms\Components\TextInput::make('jabatan_fungsional')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kepakaran')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('bidang')
                    ->maxLength(255),
                Forms\Components\TextInput::make('kategori')
                    ->required()
                    ->maxLength(255)
                    ->default('Guru'),
                Forms\Components\Textarea::make('motto')
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('foto')
                    ->image()
                    ->directory('assets/images/staff')
                    ->disk('public_path')
                    ->required(),
                Forms\Components\TextInput::make('urutan')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('aktif')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->circular()
                    ->disk('public_path')
                    ->defaultImageUrl(fn ($record) => 'https://ui-avatars.com/api/?name='.urlencode($record->nama).'&color=FFFFFF&background=09090b'),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->description(fn ($record) => 'NUPTK/NIDN: ' . ($record->nidn ?: '-'))
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('jabatan')
                    ->label('Jabatan / Kepakaran')
                    ->default(fn ($record) => $record->kepakaran ?: '-'),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Guru' => 'success',
                        'Staff' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
