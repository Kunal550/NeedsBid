<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    protected $guarded = [];
    protected $appends = ['avatar'];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAvatarAttribute()
    {
        if (array_key_exists('profile_image', $this->attributes) && (!empty($this->attributes['profile_image']))) {
            return asset('public/uploads/admin/' . $this->attributes['profile_image']);
        } else {
            return asset('public/uploads/admin/noimg.png');
        }
    }

    public function user_to_review()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
