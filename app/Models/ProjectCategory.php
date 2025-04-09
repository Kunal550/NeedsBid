<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['avatar'];
    public function getAvatarAttribute()
    {
        if (array_key_exists('image', $this->attributes) && (!empty($this->attributes['image']))) {
            return asset('public/uploads/project_category/' . $this->attributes['image']);
        } else {
            return asset('public/uploads/project_category/noimg.png');
        }
    }

    
    public function project_category_to_project()
    {
        return $this->hasMany('App\Models\Project', 'id', 'category_id');
    }
}
