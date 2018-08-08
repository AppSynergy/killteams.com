<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Console\Base\YamlCommand;
use App\Console\Base\DeployCommand;
use Symfony\Component\Yaml\Yaml;

class DeployFactions extends Command
{
    use YamlCommand;
    use DeployCommand;

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
            $id = $this->getIdByName('datasheets', $datasheet->name);
            if (!$id) {
                $row = [
                    'faction_id' => $this->getIdByName('factions', $faction->faction_keyword),
                    'name' => $datasheet->name,
                ];
                $id = \DB::table('datasheets')->insertGetId($row);
            }
            $this->initMiniatures($datasheet, $id);
        }
    }

    public function initMiniatures($datasheet, $datasheet_id)
    {
        foreach ($datasheet->minis as $mini) {
            $id = $this->getIdByName('miniatures', $mini->name);
            if (!$id) {
                $row = [
                    'datasheet_id' => $datasheet_id,
                    'name' => $mini->name,
                ];
                \DB::table('miniatures')->insert($row);
            }
        }
    }
}
