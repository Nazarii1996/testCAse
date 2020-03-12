<?php

namespace App\Http\Controllers\Admin;
use Auth;
class HomeController
{
    public function index()
    {
       // dd(Auth::user()->roles->first->permissions);
        return view('home');
    }
}
