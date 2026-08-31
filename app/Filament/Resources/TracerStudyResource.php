<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TracerStudyResource\Pages;
use App\Filament\Resources\TracerStudyResource\RelationManagers;
use App\Models\TracerStudy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TracerStudyResource extends Resource
{
    protected static ?string $model = TracerStudy::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?string $modelLabel = 'Tracer Study';
    protected static ?string $pluralModelLabel = 'Tracer Study';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Alumni')
                    ->schema([
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('jenis_kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),
                        Forms\Components\Select::make('jurusan_id')
                            ->relationship('jurusan', 'nama_jurusan')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('no_hp')
                            ->tel()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('alamat_lengkap')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Data Akademik & Pekerjaan')
                    ->schema([
                        Forms\Components\Select::make('tahun_masuk')
                            ->options(array_combine(range(date('Y'), date('Y') - 30), range(date('Y'), date('Y') - 30)))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('tahun_keluar')
                            ->options(array_combine(range(date('Y') + 5, date('Y') - 30), range(date('Y') + 5, date('Y') - 30)))
                            ->searchable()
                            ->required(),
                        Forms\Components\CheckboxList::make('status')
                            ->options([
                                'Bekerja' => 'Bekerja',
                                'Kuliah' => 'Kuliah',
                                'Wirausaha' => 'Wirausaha',
                                'Mencari Kerja' => 'Mencari Kerja',
                            ])
                            ->required()
                            ->reactive()
                            ->columns(2),
                        Forms\Components\TextInput::make('pekerjaan')
                            ->label('Posisi / Jabatan Pekerjaan')
                            ->maxLength(255)
                            ->visible(fn (\Filament\Forms\Get $get) => in_array('Bekerja', $get('status') ?? [])),
                        Forms\Components\TextInput::make('nama_perusahaan')
                            ->label('Nama Perusahaan / Instansi')
                            ->maxLength(255)
                            ->visible(fn (\Filament\Forms\Get $get) => in_array('Bekerja', $get('status') ?? [])),
                        Forms\Components\TextInput::make('kampus')
                            ->label('Nama Kampus / Universitas')
                            ->maxLength(255)
                            ->visible(fn (\Filament\Forms\Get $get) => in_array('Kuliah', $get('status') ?? [])),
                        Forms\Components\TextInput::make('jurusan_kuliah')
                            ->label('Jurusan Kuliah / Program Studi')
                            ->maxLength(255)
                            ->visible(fn (\Filament\Forms\Get $get) => in_array('Kuliah', $get('status') ?? [])),
                        Forms\Components\TextInput::make('bidang_usaha')
                            ->label('Bidang Usaha / Nama Usaha')
                            ->maxLength(255)
                            ->visible(fn (\Filament\Forms\Get $get) => in_array('Wirausaha', $get('status') ?? [])),
                        Forms\Components\Textarea::make('alamat_instansi')
                            ->label('Alamat Instansi / Kampus / Usaha')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->visible(fn (\Filament\Forms\Get $get) => count(array_diff($get('status') ?? [], ['Mencari Kerja'])) > 0),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tahun_keluar')
                    ->label('Lulus')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Bekerja' => 'success',
                        'Kuliah' => 'info',
                        'Wirausaha' => 'warning',
                        'Mencari Kerja' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('pekerjaan')
                    ->label('Pekerjaan / Usaha')
                    ->formatStateUsing(function ($record) {
                        $parts = [];
                        if (in_array('Bekerja', $record->status ?? []) && $record->pekerjaan) {
                            $parts[] = '💼 ' . $record->pekerjaan;
                        }
                        if (in_array('Wirausaha', $record->status ?? []) && $record->bidang_usaha) {
                            $parts[] = '🏪 ' . $record->bidang_usaha;
                        }
                        return empty($parts) ? '-' : implode(' | ', $parts);
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('kampus')
                    ->label('Kampus / Perusahaan')
                    ->formatStateUsing(function ($record) {
                        $parts = [];
                        if (in_array('Bekerja', $record->status ?? []) && $record->nama_perusahaan) {
                            $parts[] = '🏢 ' . $record->nama_perusahaan;
                        }
                        if (in_array('Kuliah', $record->status ?? []) && $record->kampus) {
                            $parts[] = '🎓 ' . $record->kampus;
                        }
                        return empty($parts) ? '-' : implode(' | ', $parts);
                    })
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jurusan_id')
                    ->relationship('jurusan', 'nama_jurusan')
                    ->label('Jurusan'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Bekerja' => 'Bekerja',
                        'Kuliah' => 'Kuliah',
                        'Wirausaha' => 'Wirausaha',
                        'Mencari Kerja' => 'Mencari Kerja',
                    ]),
                Tables\Filters\Filter::make('tahun_keluar')
                    ->form([
                        Forms\Components\TextInput::make('tahun_keluar')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['tahun_keluar'],
                            fn (Builder $query, $date): Builder => $query->where('tahun_keluar', $date),
                        );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\ExportAction::make()
                    ->exporter(\App\Filament\Exports\TracerStudyExporter::class),
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
            'index' => Pages\ListTracerStudies::route('/'),
            'create' => Pages\CreateTracerStudy::route('/create'),
            'edit' => Pages\EditTracerStudy::route('/{record}/edit'),
        ];
    }
}
