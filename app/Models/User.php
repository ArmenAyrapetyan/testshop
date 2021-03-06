<?php

namespace App\Models;

use App\Services\FileManager;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'role_id',
        'password',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function fio() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->last_name .' '. $this->first_name
        );
    }

    public function roleU() : Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->role->name
        );
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }

    public function changeImg($newImg, $user)
    {
        $oldImg = $user->image;
        FileManager::deleteImage($oldImg->path);
        $oldImg->delete();

        FileManager::saveImage($newImg, $user->id, User::class);
    }
}
