<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KillteamController extends Controller
{
    public function store(Request $request)
    {
        return [200, "OK", $request->input('name')];
    }
}
