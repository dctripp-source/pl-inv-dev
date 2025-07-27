<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    
    protected static ?string $navigationLabel = 'Kategorije';
    
    protected static ?string $modelLabel = 'Kategorija';
    
    protected static ?string $pluralModelLabel = 'Kategorije';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Naziv kategorije')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('icon')
                            ->label('Ikona (emoji)')
                            ->maxLength(10)
                            ->helperText('Unesite emoji ikonu za kategoriju (npr. 🌱, 🎨, ⚙️)'),
                        Forms\Components\Textarea::make('description')
                            ->label('Opis kategorije')
                            ->rows(3),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktivna')
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon')
                    ->label('Ikona')
                    ->size('lg'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Naziv')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Opis')
                    ->limit(50)
                    ->wrap(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktivna')
                    ->boolean(),
                Tables\Columns\TextColumn::make('businesses_count')
                    ->label('Broj biznisa')
                    ->counts('approvedBusinesses')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Kreirana')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Sve kategorije')
                    ->trueLabel('Aktivne')
                    ->falseLabel('Neaktivne'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}