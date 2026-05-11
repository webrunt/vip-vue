<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', [HomeController::class, 'index']);

// Admin routes moved to routes/admin.php