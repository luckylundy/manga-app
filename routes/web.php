<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TopController::class, 'index']);
Route::get('/mangas/search', [MangaController::class, 'search']);
Route::get('/mangas/{mal_id}', [MangaController::class, 'show']);
// ログインしているユーザーのみ
Route::post('/bookmarks', [BookmarkController::class, 'store'])->middleware('auth');
Route::delete('/bookmarks/{id}', [BookmarkController::class, 'destroy'])->middleware('auth');
Route::get('/mypage', [MypageController::class, 'index'])->middleware('auth');
Route::post('/reviews', [ReviewController::class, 'store'])->middleware('auth');
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
