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
        return [
            'links' => [
                'self' => url('api/factions/' . $this->id),
                'parent' => url('api/factions/'),
            ],
            'id' => $this->id,
            'name' => $this->name,
            'datasheets' => DatasheetResource::collection($this->whenLoaded('datasheets')),
            'wargear' => WargearResource::collection($this->whenLoaded('wargear')),
        ];
    }
}
