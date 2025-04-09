<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageModel extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['avatar'];
    public function getAvatarAttribute()
    {
        if (array_key_exists('image', $this->attributes) && (!empty($this->attributes['image']))) {
            return asset('public/uploads/page/' . $this->attributes['image']);
        } else {
            return asset('public/uploads/page/noimg.png');
        }
    }
    public function pages_to_about()
    {
        return $this->hasMany(AboutModel::class, 'parent_id', 'id');
    }
}
