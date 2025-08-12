<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent as AgentAgent;
use Jenssegers\Agent\Facades\Agent;

Route::post('/signup', [SignupController::class, 'store'])->name('store.user');

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/create/note', [NotesController::class, 'store'])->name('store.note');

Route::get('/dashboard', [NotesController::class, 'index'])->name('notes');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/test', function () {
    return 'hi';
});
