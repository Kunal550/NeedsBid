<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFeedbackModel extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['avatar'];
    protected $table = 'customer_feedback_models';

    public function getAvatarAttribute()
    {
        if (array_key_exists('client_image', $this->attributes) && (!empty($this->attributes['client_image']))) {
            return asset('public/uploads/client_images/' . $this->attributes['client_image']);
        } else {
            return asset('public/uploads/client_images/noimg.png');
        }
    }
}
