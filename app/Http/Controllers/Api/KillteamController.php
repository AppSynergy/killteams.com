<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KillteamCollection as KillteamCollectionResource;
use App\Models\Fighter;
use App\Models\Killteam;
use App\Models\Wargearselector;
use App\Models\Specialistselector;

class KillteamController extends Controller
{

    public function index(Request $request)
    {
        $killteams = Killteam::with(
            'faction', 'fighters', 'fighters.wargearselectors'
        )->get();
        return new KillteamCollectionResource($killteams);
    }

    public function store(Request $request)
    {
        // create a killteam
        $killteam = new Killteam;
        $killteam->name = $request->get('name');
        $killteam->user_id = 1; // @TODO auth
        $killteam->save();

        // create all fighters
        foreach ($request->get('fighters') as $fighter) {
            $fighter = new Fighter;
            $fighter->name = $fighter['name'];
            $fighter->killteam_id = $killteam->id;
            $fighter->faction_id = $fighter['factionId'];
            $fighter->miniature_id = $fighter['miniatureId'];
            $fighter->specialism_id = null; // @TODO specialisms
            $fighter->save();

            /*
            $fighter_id = $fighter->id;
            foreach ($mini['wargearSelectors'] as $selector) {
                $wgs = new Wargearselector;
                $wgs->isSelected = $selector['isSelected'];
                $wgs->option = json_encode($selector['option']);
                $wgs->replace = json_encode($selector['replace']);
                $wgs->fighter_id = $fighter_id;
                $wgs->save();
            }

            foreach ($mini['specialistSelectors'] as $selector) {
                $ss = new Specialistselector;
                $ss->fighter_id = $fighter_id;
                $ss->level = $selector['level'];
                $ss->specialism_id = $selector['specialism_id'];
                $ss->ability_id = $selector['ability_id'];
                $ss->save();
            }
            */
        }

        return [200, "OK"];
        // or whatever
    }
}
