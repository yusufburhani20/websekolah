<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Pusat Dokumen';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('judul')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('kategori')
                        ->datalist(function () {
                            $existing = \App\Models\Document::whereNotNull('kategori')->distinct()->pluck('kategori')->toArray();
                            $defaults = ['RPS', 'SPMI', 'Pedoman', 'Akreditasi', 'Lainnya'];
                            return array_values(array_unique(array_merge($defaults, $existing)));
                        })
                        ->required()
                        ->placeholder('Pilih atau ketik manual kategori baru...'),
                    Forms\Components\FileUpload::make('file_path')
                        ->label('File PDF/Doc')
                        ->directory('assets/documents')
                        ->disk('public_path')
                        ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                        ->required()
                        ->downloadable()
                        ->openable(),
                    Forms\Components\Toggle::make('publik')
                        ->label('Tampilkan ke Publik')
                        ->default(true),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Upload')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\IconColumn::make('publik')
                    ->label('Publik')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('lihat_file')
                    ->label('Lihat File')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Document $record): string => asset($record->file_path))
                    ->openUrlInNewTab()
                    ->color('success'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
