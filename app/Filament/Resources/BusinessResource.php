<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessResource\Pages;
use App\Filament\Resources\BusinessResource\RelationManagers\ImagesRelationManager;
use App\Models\Business;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    
    protected static ?string $navigationLabel = 'Biznisi';
    
    protected static ?string $modelLabel = 'Biznis';
    
    protected static ?string $pluralModelLabel = 'Biznisi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informacije o vlasniku')
                    ->schema([
                        Forms\Components\TextInput::make('owner_first_name')
                            ->label('Ime vlasnika')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('owner_last_name')
                            ->label('Prezime vlasnika')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Forms\Components\Section::make('Informacije o biznisu')
                    ->schema([
                        Forms\Components\TextInput::make('business_name')
                            ->label('Naziv biznisa')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->label('Opis biznisa')
                            ->required()
                            ->rows(4),
                        Forms\Components\Textarea::make('services')
                            ->label('Usluge/Proizvodi')
                            ->rows(3),
                        Forms\Components\Select::make('categories')
                            ->label('Kategorije')
                            ->multiple()
                            ->relationship('categories', 'name')
                            ->required(),
                    ]),

                Forms\Components\Section::make('Kontakt informacije')
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon')
                            ->required()
                            ->tel(),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        Forms\Components\TextInput::make('address')
                            ->label('Adresa')
                            ->required(),
                        Forms\Components\TextInput::make('city')
                            ->label('Grad')
                            ->required(),
                        Forms\Components\TextInput::make('website')
                            ->label('Website')
                            ->url(),
                    ])->columns(2),

                Forms\Components\Section::make('Status i napomene')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Na čekanju',
                                'approved' => 'Odobren',
                                'rejected' => 'Odbačen',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Napomene administratora')
                            ->rows(3),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('primaryImage.image_path')
                    ->label('Slika')
                    ->disk('public')
                    ->height(60)
                    ->width(80)
                    ->defaultImageUrl('/images/placeholder-business.png'),
                    
                Tables\Columns\TextColumn::make('business_name')
                    ->label('Naziv biznisa')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                    
                Tables\Columns\TextColumn::make('full_owner_name')
                    ->label('Vlasnik')
                    ->getStateUsing(fn (Business $record): string => 
                        $record->owner_first_name . ' ' . $record->owner_last_name)
                    ->searchable(['owner_first_name', 'owner_last_name'])
                    ->limit(25),
                    
                Tables\Columns\TextColumn::make('phone')
                    ->label('Telefon')
                    ->searchable()
                    ->copyable(),
                    
                Tables\Columns\TextColumn::make('city')
                    ->label('Grad')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Na čekanju',
                        'approved' => 'Odobren',
                        'rejected' => 'Odbačen',
                        default => $state,
                    }),
                    
                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Kategorije')
                    ->badge()
                    ->separator(',')
                    ->limit(20),
                    
                Tables\Columns\TextColumn::make('images_count')
                    ->label('Broj slika')
                    ->counts('images')
                    ->badge()
                    ->color('info'),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Kreiran')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Na čekanju',
                        'approved' => 'Odobren',
                        'rejected' => 'Odbačen',
                    ]),
                SelectFilter::make('categories')
                    ->label('Kategorija')
                    ->relationship('categories', 'name')
                    ->multiple(),
                SelectFilter::make('city')
                    ->label('Grad')
                    ->options(
                        Business::query()
                            ->distinct()
                            ->orderBy('city')
                            ->pluck('city', 'city')
                            ->toArray()
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('approve')
                    ->label('Odobri')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Business $record) => $record->status === 'pending')
                    ->action(function (Business $record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                            'approved_by' => auth()->id(),
                        ]);
                        
                        Notification::make()
                            ->title('Biznis je uspešno odobren!')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\Action::make('reject')
                    ->label('Odbaci')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Business $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Razlog odbacivanja')
                            ->required(),
                    ])
                    ->action(function (array $data, Business $record) {
                        $record->update([
                            'status' => 'rejected',
                            'admin_notes' => $data['admin_notes'],
                        ]);
                        
                        Notification::make()
                            ->title('Biznis je odbačen!')
                            ->warning()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('approve_selected')
                        ->label('Odobri označene')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function (Business $record) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status' => 'approved',
                                        'approved_at' => now(),
                                        'approved_by' => auth()->id(),
                                    ]);
                                }
                            });
                            
                            Notification::make()
                                ->title('Označeni biznisi su odobreni!')
                                ->success()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50]);
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBusinesses::route('/'),
            'create' => Pages\CreateBusiness::route('/create'),
            'edit' => Pages\EditBusiness::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::where('status', 'pending')->count() > 0 ? 'warning' : 'success';
    }
}