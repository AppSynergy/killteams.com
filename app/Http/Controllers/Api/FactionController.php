<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Faction as FactionResource;
use App\Http\Resources\FactionCollection as FactionCollectionResource;
use App\Models\Faction;

class FactionController extends Controller
{
    public function index()
    {
        $factions = Faction::all();
        return new FactionCollectionResource($factions);
    }

    public function show($id)
    {
        $faction = Faction::with(['datasheets', 'miniatures'])->find($id);
        return new FactionResource($faction);
    }
}
