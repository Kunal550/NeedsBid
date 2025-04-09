<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialModel extends Model
{
    
    protected $guarded = [];
    protected $appends = ['avatar'];
    protected $table = 'testimonials';
    public function getAvatarAttribute()
    {
        if (array_key_exists('testimonial_image', $this->attributes) && (!empty($this->attributes['testimonial_image']))) {
            return asset('public/uploads/testimonial_image/' . $this->attributes['testimonial_image']);
        } else {
            return asset('public/uploads/testimonial_image/noimg.png');
        }
    }
    use HasFactory;
}
