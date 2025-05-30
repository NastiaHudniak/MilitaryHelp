<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'surname',
        'name',
        'email',
        'phone',
        'address',
        'password',
        'role_id',
        'email_verified_at',
        'remember_token',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'role_id' => 'integer',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Вказуємо зв'язок з моделлю UserImage
    public function images()
    {
        return $this->hasMany(UserImage::class);
    }

    public function volunteerRatings()
    {
        return $this->hasMany(VolunteerRating::class);
    }

    public function likedApplications()
    {
        return $this->belongsToMany(Application::class, 'application_likes', 'user_id', 'application_id')->withTimestamps();
    }

// User.php

    // Кого поточний користувач додав в улюблені
    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorite_users', 'user_id', 'favorite_user_id')
            ->withTimestamps();
    }

// Користувачі, яким подобається поточний користувач
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorite_users', 'favorite_user_id', 'user_id')
            ->withTimestamps();
    }




}
