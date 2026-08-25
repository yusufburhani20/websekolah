<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Halaman Statis';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Isi Halaman')->schema([
                        Forms\Components\TextInput::make('judul')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null),
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Page::class, 'slug', ignoreRecord: true),
                        Forms\Components\ViewField::make('konten')
                            ->view('filament.forms.components.tiny-editor')
                            ->required()
                            ->columnSpanFull(),
                    ])
                ])->columnSpan(['lg' => 2]),
                
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Atribut & SEO')->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->required()
                            ->default('published'),
                        Forms\Components\Select::make('template')
                            ->options([
                                'default' => 'Default Template',
                            ])
                            ->required()
                            ->default('default'),
                        Forms\Components\Textarea::make('meta_desc')
                            ->label('Meta Deskripsi (SEO)')
                            ->rows(3)
                            ->maxLength(65535),
                    ]),
                    Forms\Components\Section::make('Gambar Utama')->schema([
                        Forms\Components\Select::make('existing_gambar')
                            ->label('Pilih dari Media Library')
                            ->options(function () {
                                $files = \Illuminate\Support\Facades\File::allFiles(public_path('assets/images'));
                                $options = [];
                                foreach ($files as $file) {
                                    if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp'])) {
                                        $relPath = 'assets/images/' . $file->getRelativePathname();
                                        $url = asset($relPath);
                                        $options[$relPath] = "<div class='flex items-center gap-2'><img src='" . $url . "' style='height: 30px; width: 30px; object-fit: cover; border-radius: 4px;'/> <span>" . $file->getFilename() . "</span></div>";
                                    }
                                }
                                return $options;
                            })
                            ->allowHtml()
                            ->searchable()
                            ->dehydrated(false)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $set('gambar', $state);
                                    $set('thumbnail', $state);
                                }
                            })
                            ->live(),
                        Forms\Components\FileUpload::make('gambar')
                            ->image()
                            ->directory('assets/images/pages')
                            ->disk('public_path')
                            ->helperText('Gambar utama (opsional) untuk halaman ini.'),
                    ]),
                ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'danger' => 'draft',
                        'success' => 'published',
                    ]),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat Halaman')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record): string => url('/halaman/' . $record->slug))
                    ->openUrlInNewTab()
                    ->color('info'),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
