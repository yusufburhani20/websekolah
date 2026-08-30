<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Media';
    protected static ?string $navigationLabel = 'Galeri';
    protected static ?string $modelLabel = 'Galeri';
    protected static ?string $pluralModelLabel = 'Galeri';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Galeri')
                    ->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('kategori')
                            ->options([
                                'Fasilitas' => 'Fasilitas',
                                'Kegiatan' => 'Kegiatan',
                                'Prestasi' => 'Prestasi',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array => Gallery::where('kategori', 'like', "%{$search}%")->limit(10)->pluck('kategori', 'kategori')->toArray())
                            ->getOptionLabelUsing(fn ($value): ?string => $value)
                            ->createOptionForm([
                                Forms\Components\TextInput::make('kategori')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->createOptionUsing(function (array $data) {
                                return $data['kategori'];
                            })
                            ->nullable(),
                        Forms\Components\Textarea::make('deskripsi')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Gambar')
                    ->schema([
                        Forms\Components\FileUpload::make('gambar')
                            ->image()
                            ->imageResizeMode('cover')->imageResizeTargetWidth('1920')->imageResizeTargetHeight('1080')
                            ->multiple()
                            ->maxFiles(20)
                            ->directory('assets/images/gallery')
                            ->disk('public_path') // Ensuring it saves directly to public folder like others
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Toggle::make('aktif')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('gambar')
                    ->disk('public_path'),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean(),
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
