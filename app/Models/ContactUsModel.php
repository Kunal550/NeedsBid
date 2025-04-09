<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
class ContactUsModel extends Model
{
    use HasFactory;
    protected $guarded = [];

    // public static function boot() {
  
    //     parent::boot();
  
    //     static::created(function ($item) {
                
    //         $adminEmail = "kunalpramanik3@gmail.com";
    //         Mail::to($adminEmail)->send(new ContactMail($item));
    //     });
    // }
}
