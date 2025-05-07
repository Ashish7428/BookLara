<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Book;

class BookApprovalMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Book Has Been Approved',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.book-approved',
        );
    }
}