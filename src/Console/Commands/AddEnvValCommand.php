<?php

namespace Innoflash\EnvUpdater\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
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
    protected $signature = 'env-add {variable : The variable you wanna add} {value? : The value you want to set for the variable} {--s|silent : To skip asking if blank values are added}';

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
     * @param \Innoflash\EnvUpdater\EnvUpdater $envUpdater
     *
     * @return mixed
     */
    public function handle(EnvUpdater $envUpdater)
    {
        $this->processEnv($envUpdater);
    }

    /**
     * @inheritDoc
     */
    protected function variableShouldExist(): bool
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    protected function nextCommand(): string
    {
        return 'env-update';
    }

    /**
     * @inheritDoc
     */
    protected function getWriteData(Collection $entries): Collection
    {
        return $entries->put($this->getVariable(), $this->getValue());
    }
}
