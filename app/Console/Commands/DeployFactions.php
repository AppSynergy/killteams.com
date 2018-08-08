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
                $this->info('Inserting datasheet: ' . $datasheet->name);
                $id = \DB::table('datasheets')->insertGetId($row);
            }
            $this->initAbilities($datasheet->abilities, $id, $faction->abilities);
            $this->initKeywords($datasheet->keywords, $id);
            $this->initMiniatures($datasheet, $id);
        }
    }

    public function initAbilities($abilities, $datasheet_id, $all_abilities)
    {
        //dump([$abilities, $datasheet_id, $all_abilities]);
    }

    public function initKeywords($keywords, $datasheet_id)
    {
        foreach ($keywords as $keyword) {
            $id = $this->getIdByName('keywords', $keyword);
            if (!$id) {
                $row = [
                    'name' => $keyword,
                ];
                $this->info('Inserting keyword: ' . $keyword);
                $id = \DB::table('keywords')->insertGetId($row);
            }
            $relation = [
                'datasheet_id' => $datasheet_id,
                'keyword_id' => $id,
            ];
            if (!$this->dataExists('datasheet_keyword', $relation)) {
                $this->info('Relating keyword: ' . $keyword);
                \DB::table('datasheet_keyword')->insert($relation);
            }
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
                $profile = explode(' ', $mini->profile);
                foreach (\Config::get('warhammer.profiles') as $i => $key) {
                    $row[$key] = $profile[$i];
                }
                $this->info('Inserting miniature: ' . $mini->name);
                $id = \DB::table('miniatures')->insertGetId($row);
            }
            $this->initWargearoptions($mini->wargear_options, $id, $mini->name);
        }
    }

    public function initWargearoptions($wargear_options, $miniature_id, $mini_name)
    {
        foreach ($wargear_options as $wargear_option) {
            $id = false;
            if (!$id) {
                $row = [
                    'miniature_id' => $miniature_id,
                    'who' => $wargear_option->who,
                    'may' => $wargear_option->may,
                    'method' => $wargear_option->method,
                    'options' => json_encode($wargear_option->options),
                ];
                //dd($wargear_option->options);
                if (property_exists($wargear_option, 'replace')) {
                    $row['replace'] = json_encode($wargear_option->replace);
                }
                $this->info('Inserting wargear option for: ' . $mini_name);
                $id = \DB::table('wargearoptions')->insertGetId($row);
            }
        }
    }

}
