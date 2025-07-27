<?php

namespace App\Filament\Resources\BusinessResource\RelationManagers;

use App\Services\ImageOptimizationService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Slike Biznisa';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_path')
                    ->label('Slika')
                    ->image()
                    ->disk('public')
                    ->directory('businesses')
                    ->required()
                    ->maxSize(10240) // 10MB max before optimization
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                    ->helperText('Maksimalno 10MB. Slika će biti automatski optimizovana na 200-700KB.')
                    ->saveUploadedFileUsing(function ($file) {
                        // Use our optimization service
                        $imageService = app(ImageOptimizationService::class);
                        return $imageService->optimizeBusinessImage($file);
                    }),
                    
                Forms\Components\TextInput::make('alt_text')
                    ->label('Alt tekst')
                    ->maxLength(255)
                    ->default(fn ($livewire) => $livewire->ownerRecord->business_name),
                    
                Forms\Components\Toggle::make('is_primary')
                    ->label('Postaviti kao glavnu sliku')
                    ->helperText('Glavna slika se prikazuje u listi biznisa'),
                    
                Forms\Components\TextInput::make('sort_order')
                    ->label('Redosled')
                    ->numeric()
                    ->default(0)
                    ->helperText('Manji broj = veći prioritet'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('alt_text')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Slika')
                    ->disk('public')
                    ->height(80)
                    ->width(120),
                    
                Tables\Columns\TextColumn::make('alt_text')
                    ->label('Alt tekst')
                    ->limit(30),
                    
                Tables\Columns\IconColumn::make('is_primary')
                    ->label('Glavna')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Redosled')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dodana')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_primary')
                    ->label('Glavna slika'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Dodaj sliku')
                    ->icon('heroicon-o-plus')
                    ->mutateFormDataUsing(function (array $data, $livewire): array {
                        $data['business_id'] = $livewire->ownerRecord->id;
                        
                        // If this is set as primary, unset other primary images
                        if ($data['is_primary'] ?? false) {
                            $livewire->ownerRecord->images()->update(['is_primary' => false]);
                        }
                        
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->mutateFormDataUsing(function (array $data, $record, $livewire): array {
                        // If this is set as primary, unset other primary images
                        if (($data['is_primary'] ?? false) && !$record->is_primary) {
                            $livewire->ownerRecord->images()->where('id', '!=', $record->id)->update(['is_primary' => false]);
                        }
                        
                        return $data;
                    }),
                    
                Tables\Actions\Action::make('set_primary')
                    ->label('Postavi kao glavnu')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->visible(fn ($record) => !$record->is_primary)
                    ->action(function ($record, $livewire) {
                        // Unset all primary images for this business
                        $livewire->ownerRecord->images()->update(['is_primary' => false]);
                        
                        // Set this image as primary
                        $record->update(['is_primary' => true]);
                        
                        Notification::make()
                            ->title('Slika je postavljena kao glavna!')
                            ->success()
                            ->send();
                    }),
                    
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        // Delete image file from storage
                        if (Storage::disk('public')->exists($record->image_path)) {
                            Storage::disk('public')->delete($record->image_path);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            // Delete image files from storage
                            foreach ($records as $record) {
                                if (Storage::disk('public')->exists($record->image_path)) {
                                    Storage::disk('public')->delete($record->image_path);
                                }
                            }
                        }),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->paginated(false);
    }
}
