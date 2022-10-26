<?php

namespace App\Models\Storage;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection<User> users
 * @property string $path
 */
class Storage extends Model
{
    use HasFactory;

    protected $table = ["storages"];
    protected $fillable = ["path"];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "user_has_storage","storage_id","user_id");
    }

}
