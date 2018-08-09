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
            'points' => $this->points,
            'specialists' => $this->specialists->pluck('name'),
            'wargear_options' => $this->wargearoptions->map(function ($x) {
                return [
                    'who' => $x->who,
                    'may' => $x->may,
                    'replace' => json_decode($x->replace),
                    'method' => $x->method,
                    'options' => json_decode($x->options),
                ];
            }),
        ];
    }
}
