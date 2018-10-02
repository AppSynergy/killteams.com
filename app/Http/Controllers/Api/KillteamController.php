<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\KillteamCollection as KillteamCollectionResource;
use App\Models\Ability;
use App\Models\Fighter;
use App\Models\Killteam;
use App\Models\Wargearselector;
use App\Models\Specialistselector;

class KillteamController extends Controller
{

    public function index(Request $request)
    {
        $killteams = Killteam::with(
            'fighters', 'fighters.specialistselector', 'fighters.specialistselector.abilities'
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
        $fighterIds = [];
        foreach ($request->get('fighters') as $fighterData) {
            if (array_key_exists('fighter_id', $fighterData)) {
                $fighter = Fighter::firstOrNew(['id' => $fighterData['fighter_id']]);
            } else {
                $fighter = new Fighter();
            }
            $fighter->name = $fighterData['name'];
            $fighter->killteam_id = $killteam->id;
            $fighter->faction_id = $fighterData['factionId'];
            $fighter->miniature_id = $fighterData['miniatureId'];

            $selector = $fighterData['specialistSelector'];
            $fighter->specialism_id = $selector['specialism_id'];
            $fighter->save();

            if (array_key_exists('selector_id', $selector)) {
                $ss = Specialistselector::firstOrNew(['id' => $selector['selector_id']]);
            } else {
                $ss = new Specialistselector;
            }
            $ss->fighter_id = $fighter->id;
            $ss->level = $selector['level'];
            $ss->specialism_id = $selector['specialism_id'];
            $ability_ids = collect($selector['abilities'])->map(function($item, $key) {
                return $item['id'];
            });
            $ss->save();
            $ss->abilities()->sync($ability_ids);



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


            $fighter->save();
            $fighterIds[] = $fighter->id;
        }

        // delete fighters
        $previousFighterIds = $killteam->fighters->map(function($fighter) {
            return $fighter['id'];
        });
        $removedFighterIds = $previousFighterIds->diff($fighterIds);
        $removedFighterIds->each(function($id) {
            Fighter::find($id)->delete();
        });
        //print_r([$fighterIds, $previousFighterIds]);

        return response($killteam->id, 200);
    }
}
