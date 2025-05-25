<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'volunteer_id',
        'millitary_id',
        'title',
        'description',
        'status',
        'comment',
    ];

    protected $casts = [
        'category_id' => 'integer',
        'volunteer_id' => 'integer',
        'millitary_id' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class);
    }

    public function millitary()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ApplicationImage::class);

    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'application_likes', 'application_id', 'user_id')
            ->withTimestamps();
    }
}
