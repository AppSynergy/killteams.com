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
        $array = [
            'id' => $this->id,
            'name' => $this->name,
            'profile' => [],
            'points' => $this->points,
            'specialists' => $this->specialists->pluck('name'),
            'armament' => $this->decode($this->armament),
            'wargear_options' => $this->wargearoptions->map(function ($x) {
                return [
                    'who' => $x->who,
                    'may' => $x->may,
                    'replace' => $this->decode($x->replace),
                    'method' => $x->method,
                    'options' => $this->decode($x->options),
                ];
            }),
        ];
        foreach (\Config::get('warhammer.profiles') as $profile) {
            $array['profile'][$profile] = $this->$profile;
        }
        $array['profile_suffixes'] = \Config::get('warhammer.suffixes');
        return $array;
    }

    protected function decode($json)
    {
        return json_decode($json);
    }
}
