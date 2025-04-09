<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::Create([
            'name' => 'needs bids admin',
            'email' => 'admin@gmail.com',
            'phone' => '9398357135',
            'password' => Hash::make('12345678'),
            'user_type_id' => 1
        ]);
    }
}
