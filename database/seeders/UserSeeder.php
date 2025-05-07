<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'Ashish',
            'last_name' => 'Rathod',
            'email' => 'arathod7676@gmail.com',
            'gender' => 'Male',
            'age' => 25,
            'password' => Hash::make('Ashish@123'),
        ]);
    }
}