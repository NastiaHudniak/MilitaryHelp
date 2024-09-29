<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationImage extends Model
{
    use HasFactory;

    protected $table = 'application_images';

    protected $fillable = [
        'application_id',
        'image_url',
    ];

    protected $casts =[
        'application_id' => 'integer',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
