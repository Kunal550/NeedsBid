<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['avatar','base_encode'];

    public function getAvatarAttribute()
    {
        if (array_key_exists('image', $this->attributes) && (!empty($this->attributes['image']))) {
            return asset('public/uploads/service/' . $this->attributes['image']);
        } else {
            return asset('public/uploads/service/noimg.png');
        }
    }
    public function getBaseEncodeAttribute()
    {
        return base64_encode($this->attributes['id']);
    }

    public function serice_to_sub_service()
    {
        return $this->hasMany('App\Models\Sub_service', 'service_id', 'id');
    }

    public function serice_to_service_images()
    {
        return $this->hasMany('App\Models\ServiceImagesModel', 'service_id', 'id');
    }
}
