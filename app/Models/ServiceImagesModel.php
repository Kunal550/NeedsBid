<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceImagesModel extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['avatar'];
    public function getAvatarAttribute()
    {
        if (array_key_exists('service_images', $this->attributes) && (!empty($this->attributes['service_images']))) {
            return asset('public/uploads/service_images/' . $this->attributes['service_images']);
        } else {
            return asset('public/uploads/service_images/noimg.png');
        }
    }
    public function service_images_to_serice()
    {
        return $this->hasOne('App\Models\Service', 'id', 'service_id');
    }
}
