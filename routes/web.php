<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return redirect()->route('articles.index');
});

Route::controller(ArticleController::class)->prefix('articles')->group(function () {
    Route::get('/',       'index')->name('articles.index');
    Route::get('/{slug}', 'show')->name('articles.show');
});

Route::controller(CommentController::class)->prefix('comments')->group(function () {
    Route::post('/update/{id}',  'update')->name('comments.update');
    Route::post('/destroy/{id}', 'destroy')->name('comments.destroy');
});