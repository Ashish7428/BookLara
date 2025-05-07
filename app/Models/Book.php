<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'author_id',
        'category_id',
        'publication_year',
        'cover_image',
        'pdf_path',
        'status',
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    protected $casts = [
        'title' => 'string',
        // Remove 'author' => 'string' since we're using relationship
    ];

    public function getCoverImageAttribute($value)
    {
        if ($value && file_exists(public_path('storage/' . $value))) {
            return asset('storage/' . $value);
        }
        return asset('images/default-book-cover.jpg');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function readingProgress()
    {
        return $this->hasMany(ReadingProgress::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');
    }
    public function bookmarks()
{
    return $this->hasMany(Bookmark::class);
}
public function comments()
{
    return $this->hasMany(Comment::class);
}
}
