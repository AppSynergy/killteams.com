<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Base\YamlCommand;
use Symfony\Component\Yaml\Yaml;
use RomaricDrigon\MetaYaml\MetaYaml;

class ValidateFactions extends Command
{
    use YamlCommand;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factions:validate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Validate production faction data.';

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
        $schema_data = $this->getFromYaml('data/factions/_schema.yaml');
        $this->schema = new MetaYaml($schema_data, true);
        $this->eachFaction([$this, 'validate']);
    }

    /**
     * Validate a single faction file.
     *
     * @return void
     */
    public function validate($faction)
    {
        $this->info('Validating ' . $faction);
        $data = $this->getFromYaml('data/' . $faction);
        $this->schema->validate($data);
    }
}
