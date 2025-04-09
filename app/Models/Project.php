<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['avatar','base_encode'];

    public function getAvatarAttribute()
    {
        if (array_key_exists('image', $this->attributes) && (!empty($this->attributes['image']))) {
            return asset('public/uploads/projects/' . $this->attributes['image']);
        } else {
            return asset('public/uploads/projects/noimg.png');
        }
    }
    public function getBaseEncodeAttribute()
    {
        return base64_encode($this->attributes['id']);
    }

    

    public function project_to_project_category()
    {
        return $this->hasOne('App\Models\ProjectCategory', 'id', 'category_id');
    }
}
