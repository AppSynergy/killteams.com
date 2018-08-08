<?php

namespace App\Console\Base;

use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class YamlCommand extends Command
{
    /**
     * Load data from a yaml file.
     *
     * @param string $path
     * @param int $flags
     * @return mixed
     */
    protected function getFromYaml($path, $flags = 0, $toObject = false)
    {
        $data = Yaml::parse(file_get_contents(resource_path($path)), $flags);
        if ($toObject) {
            $data = $this->toObject($data);
        }
        return $data;
    }

    /**
     * Convert array to a standard object.
     *
     * @param array $array
     * @return object
     */
    protected function toObject($array)
    {
        return json_decode(json_encode($array));
    }

    /**
     * Iterate over each faction.
     *
     * @param function $callback
     * @return void
     */
    protected function eachFaction($callback)
    {
        try {
            foreach (\Storage::disk('data')->files('factions') as $faction) {
                if ('factions/_' != substr($faction, 0, 10)) {
                    if (is_callable($callback)) {
                        $callback($faction);
                    }
                }
            }
        }
        catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
