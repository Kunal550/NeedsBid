<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_service extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['avatar'];

    public function getAvatarAttribute()
    {
        if (array_key_exists('image', $this->attributes) && (!empty($this->attributes['image']))) {
            return asset('public/uploads/sub_service/' . $this->attributes['image']);
        } else {
            return asset('public/uploads/sub_service/noimg.png');
        }
    }
    public function sub_service_to_service()
    {
        return $this->hasOne('App\Models\Service', 'id', 'service_id');
    }
}
