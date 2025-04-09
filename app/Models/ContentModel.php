<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentModel extends Model
{
    use HasFactory;
    protected $table = 'content_models';
    protected $guarded = [];
    protected $appends = ['avatar'];

    public function getAvatarAttribute (){
        if (array_key_exists('content_images', $this->attributes) && (!empty($this->attributes['content_images']))) {
            return asset('public/uploads/content_images/'.$this->attributes['content_images']);
        } else {
            return asset('public/uploads/content_images/noimg.png');
        }
    }
}
