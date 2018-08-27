<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fighter;
use App\Models\Killteam;

class KillteamController extends Controller
{
    public function store(Request $request)
    {
        // @TODO the current request data is just mini data farted back at you.
        // in future it'll be more structured, and map directly to columns or relations
        // on Fighter model.
        dd($request->all());
        // create a killteam
        $killteam = new Killteam;
        $killteam->name = $request->get('name');
        $killteam->faction_id = $request->get('faction_id');
        // @TODO auth
        $killteam->user_id = 1;
        $killteam->save();

        // create all fighters
        foreach ($request->get('fighters') as $mini) {
            $fighter = new Fighter;
            $fighter->name = $mini['name'];
            $fighter->killteam_id = $killteam->id;
            $fighter->miniature_id = $mini['miniatureId'];
            $fighter->save();
        }

        return [200, "OK"];
        // or whatever
    }
}
