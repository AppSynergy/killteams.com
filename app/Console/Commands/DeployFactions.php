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
    protected $signature = 'factions:deploy {--silent} {--refresh}';
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
            if ($this->option('refresh')) {
                $this->info('Migrating and seeding database...');
                $this->callSilent('migrate:refresh', ['--seed']);
            }
            $this->info('Deploying factions silently...');
            $this->callSilent('factions:validate');
            $this->callSilent('factions:fulldeployment');
        } else {
            if ($this->option('refresh')) {
                $this->call('migrate:refresh', ['--seed']);
            }
            $this->call('factions:validate');
            $this->call('factions:fulldeployment');
        }
        $this->info('Deployment complete.');
    }
}
