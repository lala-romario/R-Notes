<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use Illuminate\Routing\Controllers\Middleware;


Route::post('/create', [UsersController::class, 'store']);


