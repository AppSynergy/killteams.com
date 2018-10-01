<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Specialistselector extends JsonResource
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
            'id' => $this->id,
            'fighter_id' => $this->fighter_id,
            'specialism_id' => $this->specialism_id,
            'level' => $this->level,
        ];
    }
}
