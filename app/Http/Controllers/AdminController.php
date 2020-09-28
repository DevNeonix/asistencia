<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function toLogin()
    {
        return redirect()->to('login');
    }
    function toHome(){
        return view('pages.home');
    }
}
