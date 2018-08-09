<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Faction as FactionResource;
use App\Models\Faction;

class FactionController extends Controller
{
    public function index()
    {
        return FactionResource::collection(Faction::all());
    }
}
