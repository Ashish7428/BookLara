<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;    

class Author extends Authenticatable
{
    protected $fillable = [
        'full_name',
        'username',
        'email',
        'password',
        'bio',
        'profile_image',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
