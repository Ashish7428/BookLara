<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'gender',
        'age',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // Add the reviews relationship
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        return $this->roles()->where('slug', $role)->exists();
    }

    public function assignRole($role)
    {
        return $this->roles()->attach(Role::where('slug', $role)->first());
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function bookmarkedBooks()
    {
        return $this->belongsToMany(Book::class, 'bookmarks');
    }

    public function readingProgress()
    {
        return $this->hasMany(ReadingProgress::class);
    }

    public function books()
    {
        return $this->hasManyThrough(Book::class, ReadingProgress::class, 'user_id', 'id', 'id', 'book_id');
    }
    public function comments()
{
    return $this->hasMany(Comment::class);
}
}
