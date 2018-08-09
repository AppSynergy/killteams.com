<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Miniature extends JsonResource
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
            'name' => $this->name,
            'specialists' => $this->specialists->pluck('name'),
            'wargear_options' => $this->wargearoptions->map(function ($x) {
                return $x->only([
                    'who', 'may', 'replace', 'method', 'options'
                ]);
            }),
        ];
    }
}
