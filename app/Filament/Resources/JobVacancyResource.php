<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobVacancyResource\Pages;
use App\Filament\Resources\JobVacancyResource\RelationManagers;
use App\Models\JobVacancy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobVacancyResource extends Resource
{
    protected static ?string $model = JobVacancy::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationGroup = 'BKK (Bursa Kerja)';
    protected static ?string $navigationLabel = 'Lowongan Kerja';
    protected static ?string $pluralModelLabel = 'Lowongan Kerja';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('company_id')
                    ->relationship('company', 'nama_perusahaan')
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('judul_lowongan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('posisi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('tipe_pekerjaan')
                    ->options([
                        'Full-time' => 'Full-time',
                        'Part-time' => 'Part-time',
                        'Magang/Internship' => 'Magang/Internship',
                        'Kontrak' => 'Kontrak',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('lokasi_penempatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('batas_lamaran')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),
                Forms\Components\Select::make('jurusan_terkait')
                    ->multiple()
                    ->relationship('company', 'nama_perusahaan')
                    ->options(\App\Models\Jurusan::pluck('nama_jurusan', 'id'))
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('deskripsi_pekerjaan')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('persyaratan')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('company.nama_perusahaan')
                    ->label('Perusahaan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul_lowongan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('posisi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tipe_pekerjaan')
                    ->badge(),
                Tables\Columns\TextColumn::make('batas_lamaran')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')
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
            'index' => Pages\ListJobVacancies::route('/'),
            'create' => Pages\CreateJobVacancy::route('/create'),
            'edit' => Pages\EditJobVacancy::route('/{record}/edit'),
        ];
    }
}
