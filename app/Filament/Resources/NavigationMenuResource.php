<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavigationMenuResource\Pages;
use App\Models\NavigationMenu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class NavigationMenuResource extends Resource
{
    protected static ?string $model = NavigationMenu::class;

    protected static ?string $navigationIcon = 'heroicon-o-bars-3';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $navigationLabel = 'Menu Navigasi';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Select::make('parent_id')
                        ->label('Induk Menu (Pilih untuk menjadikannya Sub-menu)')
                        ->options(function (?NavigationMenu $record) {
                            $query = NavigationMenu::where('parent_id', 0);
                            if ($record) {
                                $query->where('id', '!=', $record->id);
                            }
                            $menus = $query->pluck('nama_menu', 'id')->toArray();
                            return [0 => '— Jadikan Menu Utama —'] + $menus;
                        })
                        ->default(0)
                        ->searchable()
                        ->helperText('Pilih "— Jadikan Menu Utama —" jika ingin merubah sub-menu kembali menjadi menu utama.'),
                    Forms\Components\TextInput::make('nama_menu')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('url')
                        ->label('URL / Link')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Contoh: /pages/profil atau https://google.com'),
                    Forms\Components\TextInput::make('urutan')
                        ->numeric()
                        ->default(0)
                        ->required(),
                    Forms\Components\Select::make('target')
                        ->options([
                            '_self' => 'Tab Saat Ini (_self)',
                            '_blank' => 'Tab Baru (_blank)',
                        ])
                        ->default('_self')
                        ->required(),
                    Forms\Components\Toggle::make('status')
                        ->label('Status Aktif')
                        ->default(true),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_menu')
                    ->label('Nama Menu')
                    ->formatStateUsing(fn ($state, $record) => $record->parent_id == 0 ? $state : '— ' . $state)
                    ->weight(fn ($record) => $record->parent_id == 0 ? 'bold' : 'normal')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tipe')
                    ->label('Tipe')
                    ->getStateUsing(fn ($record) => $record->parent_id == 0 ? 'Utama' : 'Sub Menu')
                    ->badge()
                    ->color(fn ($state) => $state === 'Utama' ? 'success' : 'warning'),
                Tables\Columns\TextColumn::make('parent.nama_menu')
                    ->label('Induk Menu')
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL / Link')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\IconColumn::make('status')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('urutan')
                    ->sortable(),
            ])
            ->defaultSort('urutan')
            ->reorderable('urutan')
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNavigationMenus::route('/'),
            'create' => Pages\CreateNavigationMenu::route('/create'),
            'edit' => Pages\EditNavigationMenu::route('/{record}/edit'),
        ];
    }
}
