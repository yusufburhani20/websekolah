<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Isi Artikel')->schema([
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
                            ->unique(Post::class, 'slug', ignoreRecord: true),
                        Forms\Components\ViewField::make('isi')
                            ->view('filament.forms.components.tiny-editor')
                            ->required()
                            ->columnSpanFull(),
                    ])
                ])->columnSpan(['lg' => 2]),
                
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Pengaturan')->schema([
                        Forms\Components\Select::make('kategori')
                            ->options([
                                'Akademik' => 'Akademik',
                                'Kesiswaan' => 'Kesiswaan',
                                'Prestasi' => 'Prestasi',
                                'Agenda' => 'Agenda',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('ringkasan')
                            ->rows(3)
                            ->required()
                            ->maxLength(65535),
                        Forms\Components\DateTimePicker::make('tanggal_posting')
                            ->required()
                            ->default(now()),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->required()
                            ->default('published'),
                    ]),
                    Forms\Components\Section::make('Upload Media')->schema([
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
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Foto Utama (Thumbnail)')
                            ->image()
                            ->directory('assets/images/berita/thumbnail')
                            ->disk('public_path')
                            ->helperText('Hanya bisa mengunggah 1 gambar untuk dijadikan sampul depan berita.'),
                        Forms\Components\FileUpload::make('foto')
                            ->label('Galeri Foto Tambahan (Slider)')
                            ->image()
                            ->directory('assets/images/berita')
                            ->disk('public_path')
                            ->multiple()
                            ->reorderable()
                            ->helperText('Opsional: Bisa mengunggah banyak foto sekaligus yang akan ditampilkan sebagai slider di detail berita.'),
                    ]),
                ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->disk('public_path'),
                Tables\Columns\TextColumn::make('judul')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Akademik' => 'primary',
                        'Kesiswaan' => 'success',
                        'Prestasi' => 'warning',
                        'Agenda' => 'info',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('tanggal_posting')
                    ->label('Tgl Posting')
                    ->dateTime('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'danger' => 'draft',
                        'success' => 'published',
                    ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('lihat')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record): string => url('/berita/' . $record->slug))
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
