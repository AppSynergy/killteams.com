<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Datasheet;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', [
            'datasheets' => Datasheet::with([
                'abilities', 'keywords', 'miniatures'
            ])->get(),
        ]);
    }
}
