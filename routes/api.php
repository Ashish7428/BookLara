<?php
use App\Http\Controllers\ReadingProgressController;

Route::post('/save-progress', [ReadingProgressController::class, 'saveProgress']);