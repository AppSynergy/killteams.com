<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Yaml\Yaml;

class DeployFactions extends Command
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
        $this->info("Deploying factions...");
        $file = resource_path('data/factions/AdeptusMechanicus.yaml');
        $data = Yaml::parse(file_get_contents($file));
        dd($data);

    }
}
