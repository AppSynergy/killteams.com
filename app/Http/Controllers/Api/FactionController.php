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
        $factions = Faction::with(['datasheets', 'wargears'])->get();
        return new FactionCollectionResource($factions);
    }

    public function show($id)
    {
        $faction = Faction::with(['datasheets', 'wargears'])->find($id);
        return new FactionResource($faction);
    }
}
