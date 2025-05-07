<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReadingProgress extends Model
{
    protected $table = 'reading_progress';
    
    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'progress',
        'reading_time',
        'total_pages',
        'current_page'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
