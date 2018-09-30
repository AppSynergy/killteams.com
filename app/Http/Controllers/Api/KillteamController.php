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
            'fighters' //'fighters.wargearselectors'
        )->get();
        return new KillteamCollectionResource($killteams);
    }

    public function store(Request $request)
    {
        // create a killteam
        $killteam = Killteam::firstOrNew(['id' => $request->get('id')]);
        $killteam->name = $request->get('name');
        $killteam->user_id = 1; // @TODO auth
        $killteam->save();

        // create all fighters
        foreach ($request->get('fighters') as $fighterData) {
            if (array_key_exists('fighterId', $fighterData)) {
                $fighter = Fighter::firstOrNew(['id' => $fighterData['fighterId']]);
            } else {
                $fighter = new Fighter();
            }
            $fighter->name = $fighterData['name'];
            $fighter->killteam_id = $killteam->id;
            $fighter->faction_id = $fighterData['factionId'];
            $fighter->miniature_id = $fighterData['miniatureId'];


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
            */

            $selector = $fighterData['specialistSelector'];

            if (array_key_exists('specialismId', $selector) && $selector['specialismId'] != null) {
                if (array_key_exists('selectorId', $selector)) {
                    $ss = Specialistselector::firstOrNew(['id' => $selector['selectorId']]);
                } else {
                    $ss = new Specialistselector;
                }
                $ss->fighter_id = $fighter->id;
                $ss->level = $selector['level'];
                $ss->specialism_id = $selector['specialismId'];
                $ss->ability_id = 1; // @TODO rm
                $ss->save();
                $fighter->specialism_id = $ss->id;
            }


            $fighter->save();
        }

        return response($killteam->id, 200);
    }
}
