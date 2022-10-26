<?php

namespace App\Services;

use App\Models\Storage\Storage;
use App\Models\User;

class StorageService
{
    public static function assignStorageToUser(Storage $storage, User $user): void
    {
        $user->storages()->sync($storage, false);
    }

    public static function createNewStorage(): Storage
    {
        $storage = Storage::create([
            "path" => uniqid() . uniqid() . uniqid(),
        ]);
        $storage->save();
        return $storage;
    }
}
