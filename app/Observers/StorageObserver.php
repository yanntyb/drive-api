<?php

namespace App\Observers;

use App\Models\Storage\Storage;
use Illuminate\Support\Facades\Storage as StorageFace;

class StorageObserver
{
    public function created(Storage $storage)
    {
        StorageFace::disk('user-drive')->makeDirectory($storage->path);
    }
}
