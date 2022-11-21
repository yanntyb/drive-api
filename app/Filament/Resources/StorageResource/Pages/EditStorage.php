<?php

namespace App\Filament\Resources\StorageResource\Pages;

use App\Filament\Resources\StorageResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorage extends EditRecord
{
    protected static string $resource = StorageResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            StorageResource\Widgets\StorageUsedChart::class,
        ];
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
