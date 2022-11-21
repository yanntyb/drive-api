<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\StorageResource;
use App\Filament\Resources\StorageResource\Pages\EditStorage;
use App\Models\Storage\Storage;
use Filament\Forms;
use Filament\Tables\Actions\Action;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class StoragesRelationManager extends RelationManager
{
    protected static string $relationship = 'Storages';

    protected static ?string $recordTitleAttribute = 'path';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('path')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make("size")
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(StorageResource::table($table)->getColumns())
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Action::make("Access storage page")
                    ->url(fn (Storage $record): string => StorageResource::getUrl('edit', [
                        'record' => $record,
                    ])),
            ])
            ->bulkActions([
            ]);
    }
}
