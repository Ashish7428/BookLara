<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Book;
use App\Mail\BookApprovalMail;
use Illuminate\Support\Facades\Mail;

class SendBookApprovalEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $book;

    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function handle()
    {
        Mail::to($this->book->author->email)->send(new BookApprovalMail($this->book));
    }
}