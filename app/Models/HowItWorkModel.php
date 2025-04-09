<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowItWorkModel extends Model
{
    protected $guarded = [];
    use HasFactory;
    protected $appends = ['avatar'];

    public function getAvatarAttribute()
    {
        if (array_key_exists('how_it_work_image', $this->attributes) && (!empty($this->attributes['how_it_work_image']))) {
            return asset('public/uploads/how_it_work/' . $this->attributes['how_it_work_image']);
        } else {
            return asset('public/uploads/banner/noimg.png');
        }
    }
}
