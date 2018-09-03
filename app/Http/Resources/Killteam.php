<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Faction as FactionResource;
use App\Http\Resources\Fighter as FighterResource;

class Killteam extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'faction_id' => $this->faction_id,
            'faction' => new FactionResource($this->whenLoaded('faction')),
            'fighters' => FighterResource::collection($this->whenLoaded('fighters')),
        ];

        return $array;
    }
}
