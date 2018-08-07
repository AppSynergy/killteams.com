<?php

namespace App\Console\Base;

use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class YamlCommand extends Command
{
    /**
     * Load data from a yaml file.
     *
     * @return mixed
     */
    protected function getFromYaml($path)
    {
        return Yaml::parse(file_get_contents(resource_path($path)));
    }

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
