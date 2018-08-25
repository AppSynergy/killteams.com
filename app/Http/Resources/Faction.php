<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Datasheet as DatasheetResource;
use App\Http\Resources\Wargear as WargearResource;

class Faction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = [
            'links' => [
                'self' => url('api/factions/' . $this->id),
                'parent' => url('api/factions/'),
            ],
            'id' => $this->id,
            'name' => $this->name,
            'faction_keyword' => $this->faction_keyword,
            'has_datasheets' => $this->hasDatasheets,
            'datasheets' => DatasheetResource::collection($this->whenLoaded('datasheets')),
            'wargear' => WargearResource::collection($this->whenLoaded('wargears')),
            'narrative' => [],
        ];

        $config = collect(\Config::get('narrative.names'));
        if ($config->has($this->faction_keyword)) {
            $array['narrative']['names'] = $config->first(function($v, $k) {
                return $k == $this->faction_keyword;
            });
        }

        return $array;
    }
}
