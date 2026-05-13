<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Members\MemberController;

Route::get('/login', [MemberController::class, 'login'])->name('members.login');
