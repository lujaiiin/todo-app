<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TaskController;

use App\Http\Controllers\DayController;

use App\Http\Controllers\ScreenshotController;

Route::resource('tasks', TaskController::class);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/view', function () {
    return view('view');
});

Route::get('/dailay', function () {
    return view('dailay');
});
Route::get('/todo', function () {
    return view('todo');
});




Route::put('/tasks/{taskId}/toggle-completion', [TaskController::class, 'toggleCompletion'])->name('tasks.toggleCompletion');



// In your web routes file
Route::get('/view-screenshots', [ScreenshotController::class, 'index'])->name('screenshots.index');
Route::post('/save-screenshot', [ScreenshotController::class, 'store'])->name('screenshots.store');





// In routes/web.php
Route::get('/day/{id}', [DayController::class, 'showDay'])->name('showDay');
Route::post('/day/{day_id}', [DayController::class, 'store'])->name('day.store');
Route::put('/day/{date}', [DayController::class, 'update'])->name('day.update');





Route::post('/upload-screenshot', [ScreenshotController::class, 'store']);