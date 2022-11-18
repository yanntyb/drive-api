<?php

namespace App\Observers;

use App\Models\Storage\Storage;

class StorageObserver
{
    public function created(Storage $storage)
    {
        \Illuminate\Support\Facades\Storage::disk('user-drive')->makeDirectory($storage->path);
    }
}
