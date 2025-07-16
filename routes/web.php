<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return view('auth.signin');
});
Route::middleware('auth')->group(function () {

    Route::get('/table', [PostController::class, 'get_data'])->name('get_data');
    Route::delete('/posts/{id}', [PostController::class, 'delete'])->name('delete.post');
    Route::get('/update_get_data/{id}', [PostController::class, 'updateGetData'])->name('update_get_data');
    Route::post('/generate-summary', [PostController::class, 'generateSummary'])->name('generate.summary');
    Route::post('/generate-slug', [PostController::class, 'generateSlug'])->name('generate.slug');

    Route::put('/post_update/{id}', [PostController::class, 'update']);
    Route::post('/create_post', [PostController::class, 'create']);
    Route::post('/logout', [LoginController::class, 'logout']);

});

Route::post('/logins', [LoginController::class, 'loginCredential'])->name('logins');
