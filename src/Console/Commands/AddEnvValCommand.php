<?php

namespace Innoflash\EnvUpdater\Console\Commands;

use Illuminate\Console\Command;
use Innoflash\EnvUpdater\Concerns\SavesToEnv;
use Innoflash\EnvUpdater\EnvUpdater;

class AddEnvValCommand extends Command
{
    use SavesToEnv;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env-add {variable : The variable you wanna add} {value? : The value you want to set for the variable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @param  \Innoflash\EnvUpdater\EnvUpdater  $envUpdater
     *
     * @return mixed
     */
    public function handle(EnvUpdater $envUpdater)
    {

    }
}
