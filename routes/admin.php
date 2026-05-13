<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/page', [AdminController::class, 'page'])->name('admin.page');
