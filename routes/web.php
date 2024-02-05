<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Posts resourcefull controllers routes
    Route::resource('posts', PostController::class);

    // Comments routes
    Route::group(['prefix' => '/comments', 'as' => 'comments.'], function() {
        // store comment route
        Route::post('/{post}', [CommentController::class, 'store'])->name('store');
    });

    // Replies routes
    Route::group(['prefix' => '/replies', 'as' => 'replies.'], function() {
        // store reply route
        Route::post('/{comment}', [ReplyController::class, 'store'])->name('store');
    });


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
