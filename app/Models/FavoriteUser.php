<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteUser extends Model
{
    protected $table = 'favorite_users';

    protected $fillable = [
        'user_id',
        'favorite_user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function favorite(): BelongsTo
    {
        return $this->belongsTo(User::class, 'favorite_user_id');
    }
}
