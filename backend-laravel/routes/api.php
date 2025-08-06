<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;


Route::post('/signup', [UsersController::class, 'store'])->name('store.user');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/create/note', [NotesController::class, 'store'])->name('store.note')->name('create.note');

Route::get('dashboard', [NotesController::class, 'index'])->name('notes');

Route::get('/test', function () {
    return 'hi';
});


