<?php

namespace App\Console\Commands;

use App\Console\Base\YamlCommand;
use Symfony\Component\Yaml\Yaml;

class DeployFactions extends YamlCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factions:deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy production faction data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->call('factions:validate');
        $this->info('Deploying factions...');
        $this->eachFaction([$this, 'deploy']);
    }

    /**
     * Deploy a single faction file.
     */
    public function deploy($file)
    {
        $faction = $this->getFromYaml('data/' . $file, 0, true);
        $this->initDatasheets($faction);
    }

    /**
     * Initialize datasheets.
     */
     public function initDatasheets($faction)
     {
         foreach ($faction->datasheets as $datasheet) {
             $row = [
                 'name' => $datasheet->name,
             ];
             dump($row);
         }
     }
}
