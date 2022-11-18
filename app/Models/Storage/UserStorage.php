<?php

namespace App\Models\Storage;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property User $user
 * @property Storage $storage
 */
class UserStorage extends Model
{
    use HasFactory;

    protected $table = "user_has_storages";

    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function storage(): HasOne
    {
        return $this->hasOne(Storage::class, "id", "storage_id");
    }
}
