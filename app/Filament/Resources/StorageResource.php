<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StorageResource\Pages;
use App\Filament\Resources\StorageResource\Widgets\StorageUsedChart;
use App\Models\Storage\Storage;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use StorageService;

class StorageResource extends Resource
{
    protected static ?string $model = Storage::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("id"),
                Tables\Columns\TextColumn::make('used_storage')
                    ->getStateUsing(static function(Storage $record): string{
                        return StorageService::getDirectoryUsedSized($record) / 1000 . " ko / " . $record->size . " mo";
                    }),
                Tables\Columns\TextColumn::make('users_count')
                    ->getStateUsing(static function(Storage $record): string {
                        return $record->users->count();
                    }),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStorages::route('/'),
            'edit' => Pages\EditStorage::route('/{record}/edit'),
//            'create' => Pages\CreateStorage::route('/create'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            StorageUsedChart::class,
        ];
    }
}
