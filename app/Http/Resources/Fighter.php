<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Specialistselector as SSResource;
use App\Models\Wargearoption;


class Fighter extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $wargear_options = Wargearoption::find(['miniature_id', $this->miniature_id]);
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'faction_id' => $this->faction_id,
            'miniature_id' => $this->miniature_id,
            'specialism_id' => $this->specialism_id,
            'specialistSelector' => new SSResource($this->whenLoaded('specialistselector')),
            //'wargear_options' => $wargear_options,
            //'wargearSelectors' => $this->wargearselectors,
        ];

        return $array;
    }
}
