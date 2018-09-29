<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
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
    
        return [
            'name' => $this->name,
            'miniature_id' => $this->miniature_id,
            'specialism_id' => $this->specialism_id,
            'wargear_options' => $wargear_options,
            'wargearSelectors' => $this->wargearselectors,
        ];
    }
}
