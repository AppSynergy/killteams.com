<?php

namespace App\Http\Controllers;

use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('home.index');
    }
}
