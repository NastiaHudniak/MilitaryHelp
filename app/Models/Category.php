<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\TextUI\Application;

class Category extends Model
{
    use HasFactory;
    protected $fillable =
        [
            'name',
        ];

    public  function applications()
    {
        return $this->hasMany(Application::class);
    }
}
