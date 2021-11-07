<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthenticationController extends Controller
{
    //
    function __construct()
    {
    }

    protected function admin_login(){
        return Inertia::render("AdminLogin");
    }
}
