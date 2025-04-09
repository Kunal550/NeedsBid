<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aboutus extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['avatar'];

    public function getAvatarAttribute()
    {
        if (array_key_exists('image', $this->attributes) && (!empty($this->attributes['image']))) {
            return asset('public/uploads/aboutus/' . $this->attributes['image']);
        } else {
            return asset('public/uploads/aboutus/noimg.png');
        }
    }
}
