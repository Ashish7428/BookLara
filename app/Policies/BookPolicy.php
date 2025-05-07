<?php

namespace App\Policies;

use App\Models\Author;
use App\Models\Book;

class BookPolicy
{
    public function update(Author $author, Book $book)
    {
        return $author->id === $book->author_id;
    }

    public function delete(Author $author, Book $book)
    {
        return $author->id === $book->author_id;
    }
}