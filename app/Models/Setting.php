<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['avatar'];
    public function getAvatarAttribute()
    {
        if (array_key_exists('site_image', $this->attributes) && (!empty($this->attributes['site_image']))) {
            return asset('public/uploads/setting/' . $this->attributes['site_image']);
        } else {
            return asset('public/uploads/setting/noimg.png');
        }
    }
}
