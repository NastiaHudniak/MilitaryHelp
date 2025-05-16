<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerRating extends Model
{
    use HasFactory;

    protected $table = 'volunteer_rating';

    protected $fillable = [
        'user_id',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
