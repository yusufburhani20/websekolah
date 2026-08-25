<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MediaLibraryResource\Pages;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MediaLibraryResource extends Resource
{
    protected static ?string $model = Media::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Media Library';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('file_name')
                        ->label('Upload File')
                        ->directory('assets/images/library')
                        ->disk('public_path')
                        ->image()
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\ImageColumn::make('file_name')
                        ->label('Preview')
                        ->height(150)
                        ->width('100%')
                        ->extraImgAttributes(['class' => 'object-cover rounded-t-lg']),
                    Tables\Columns\TextColumn::make('name')
                        ->weight('bold')
                        ->alignCenter()
                        ->searchable(),
                    Tables\Columns\TextColumn::make('size')
                        ->formatStateUsing(fn ($state) => number_format($state / 1024, 2) . ' KB')
                        ->color('gray')
                        ->alignCenter(),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
                'xl' => 4,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->button()
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->extraAttributes(['class' => 'w-full']),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMediaLibraries::route('/'),
        ];
    }
}
