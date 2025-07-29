<?php

use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use Illuminate\Routing\Controllers\Middleware;


Route::post('/create', [UsersController::class, 'store'])->name('store.user');

Route::post('/create/note', [NotesController::class, 'store'])->name('store.note');

Route::get('/test', function () {
    return 'hi';
});


