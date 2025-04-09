<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['avatar'];
    protected $table = 'blog_models';
    public function getAvatarAttribute()
    {
        if (array_key_exists('blog_images', $this->attributes) && (!empty($this->attributes['blog_images']))) {
            return asset('public/uploads/blog/' . $this->attributes['blog_images']);
        } else {
            return asset('public/uploads/blog/noimg.png');
        }
    }
}
