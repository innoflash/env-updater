<?php

namespace Innoflash\EnvUpdater\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Innoflash\EnvUpdater\EnvUpdater;

class UpdateEnvValCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env-update {variable : The variable you wanna update} {value? : The value you want to set for the variable}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates a .env value.';

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
        $var = Str::upper($this->argument('variable'));

        if (! in_array($var, $envUpdater->getEntries()->keys()->toArray())) {
            $this->error('The .env does not have the '.$var.' variable. Consider using "php artisan env-add"');
        }

        if (! $value = $this->argument('value')) {
            $useBlank = $this->confirm('Looks like you didn`t set a value for this variable. Do you want to use a blank for this?');
            if ($useBlank) {
                $value = '';
            } else {
                $value = $this->ask('Please enter the value you want to set for '.$var);
            }
        }

        if (Str::contains($value, ' ')) {
            $value = '"'.$value.'"';
        }

        $newData = $envUpdater->getEnvOriginalEntries()
            ->map(function ($entry) use ($var, $value) {
                if (Str::startsWith($entry, $var)) {
                    return $var.'='.$value;
                }

                return $entry;
            });

        if ($envUpdater->writeEnvFile($newData)) {
            $this->info($var.' updated successfully');
        }else{
            $this->error('Failed to write the new value');
        };
    }
}
