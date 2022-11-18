<?php

namespace App\Filament\Resources;

use App\Facades\StorageService;
use App\Filament\Resources\StorageResource\Pages;
use App\Models\Storage\Storage;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

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
                Tables\Columns\TextColumn::make('storage_size'),
                Tables\Columns\TextColumn::make('used_storage')
                    ->getStateUsing(function(Storage $record): string{
                        return StorageService::getDirectoryUsedSized($record);
                    })
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStorages::route('/'),
//            'create' => Pages\CreateStorage::route('/create'),
//            'edit' => Pages\EditStorage::route('/{record}/edit'),
        ];
    }
}
