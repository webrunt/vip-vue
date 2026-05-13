<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

class AdminController extends Controller
{

    public function login()
    {
        return Inertia::render('Admin/Login');
    }
    
    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard');
    }

    public function page()
    {
        return Inertia::render('Admin/Page');
    }    
}
