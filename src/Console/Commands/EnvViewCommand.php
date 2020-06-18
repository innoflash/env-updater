<?php

namespace Innoflash\EnvUpdater\Console\Commands;

use Illuminate\Console\Command;
use Innoflash\EnvUpdater\EnvUpdater;

class EnvViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env-view';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reads and display the values in the .env file';

    /**
     * Create a new command instance.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param  \Innoflash\EnvUpdater\EnvUpdater  $envUpdater
     *
     * @return mixed
     */
    public function handle(EnvUpdater $envUpdater)
    {
        $this->info('all is ok');

        $tableEntries = $envUpdater->getEntries()->map(function($val, $key){
            return [$key, $val];
        });
        $this->table(['Key', 'Value'], $tableEntries);
    }
}
