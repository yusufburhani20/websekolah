<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobApplicationResource\Pages;
use App\Filament\Resources\JobApplicationResource\RelationManagers;
use App\Models\JobApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'BKK (Bursa Kerja)';
    protected static ?string $navigationLabel = 'Pelamar';
    protected static ?string $pluralModelLabel = 'Pelamar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('job_vacancy_id')
                    ->relationship('jobVacancy', 'judul_lowongan')
                    ->required(),
                Forms\Components\TextInput::make('nama_pelamar')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun_lulus')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('no_hp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status_lamaran')
                    ->options([
                        'Menunggu' => 'Menunggu',
                        'Diproses' => 'Diproses',
                        'Lolos' => 'Lolos',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->required()
                    ->default('Menunggu'),
                Forms\Components\FileUpload::make('file_cv')
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('cv_pelamar')
                    ->maxSize(2048) // 2MB max
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('pesan_pengantar')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jobVacancy.judul_lowongan')
                    ->label('Lowongan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pelamar')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_lulus')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_cv')
                    ->label('File CV')
                    ->formatStateUsing(fn ($state) => $state ? 'Download CV' : 'Tidak ada')
                    ->url(fn ($record) => $record->file_cv ? asset('storage/' . $record->file_cv) : null)
                    ->openUrlInNewTab()
                    ->color('primary')
                    ->icon('heroicon-o-arrow-down-tray'),
                Tables\Columns\TextColumn::make('status_lamaran')
                    ->badge()
                    ->colors([
                        'warning' => 'Menunggu',
                        'primary' => 'Diproses',
                        'success' => 'Lolos',
                        'danger' => 'Ditolak',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListJobApplications::route('/'),
            'create' => Pages\CreateJobApplication::route('/create'),
            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}
