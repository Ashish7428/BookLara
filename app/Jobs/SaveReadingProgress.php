<?php

namespace App\Jobs;

use App\Models\ReadingProgress;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SaveReadingProgress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $bookId;
    protected $currentPage;

    public function __construct($userId, $bookId, $currentPage)
    {
        $this->userId = $userId;
        $this->bookId = $bookId;
        $this->currentPage = $currentPage;
    }

    public function handle()
    {
        $progress = ReadingProgress::where('user_id', $this->userId)
            ->where('book_id', $this->bookId)
            ->first();

        if ($progress) {
            $percentComplete = ($this->currentPage / $progress->total_pages) * 100;

            $progress->update([
                'current_page' => $this->currentPage,
                'progress' => $percentComplete,
                'status' => $this->currentPage >= $progress->total_pages ? 'completed' : 'reading'
            ]);
        }
    }
}
