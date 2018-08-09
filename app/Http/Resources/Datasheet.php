<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Miniature as MiniatureResource;

class Datasheet extends JsonResource
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
            'keywords' => $this->keywords->pluck('name'),
            'abilities' => $this->abilities->pluck('name'),
            'miniatures' => MiniatureResource::collection($this->miniatures),
        ];
    }
}
