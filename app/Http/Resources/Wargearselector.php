<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Ability as AbilityResource;

class Wargearselector extends JsonResource
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
            'isSelected' => $this->isSelected,
            'replace' => $this->replace,
            'option' => $this->option,
        ];
    }
}
