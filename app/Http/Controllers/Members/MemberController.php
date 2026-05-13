<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

class MemberController extends Controller
{

    public function login()
    {
        return Inertia::render('Members/Login');
    } 
}
