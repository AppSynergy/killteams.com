<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeployFactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factions:deploy {--silent}';
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
        if ($this->option('silent')) {
            $this->info('Deploying factions silently...');
            $this->callSilent('factions:validate');
            $this->callSilent('factions:fulldeployment');
        } else {
            $this->call('factions:validate');
            $this->call('factions:fulldeployment');
        }

    }
}
