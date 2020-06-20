<?php

namespace Innoflash\EnvUpdater\Concerns;

use Illuminate\Support\Str;
use Innoflash\EnvUpdater\EnvUpdater;

trait SavesToEnv
{
    /**
     * Whether the .env should have this variable or not.
     *
     * @return bool
     */
    protected abstract function variableShouldExist(): bool;

    /**
     * The command to run if confirmed.
     *
     * @return string
     */
    protected abstract function nextCommand(): string;

    /**
     * Converts the variable to uppercase.
     *
     * @return string
     */
    protected function getVariable(): string
    {
        return Str::upper($this->argument('variable'));
    }

    /**
     * Return the value to be set on the variable.
     *
     * @return string
     */
    protected function getValue(): string
    {
        if ($this->option('silent')) {
            return $this->argument('value') ?? '';
        }

        if (! $value = $this->argument('value')) {
            $useBlank = $this->confirm('Looks like you didn`t set a value for this variable. Do you want to use a blank for this?');
            if ($useBlank) {
                return '';
            }

            $value = $this->ask('Please enter the value you want to set for '.$value);
        }

        if (Str::contains($this->getValue(), ' ')) {
            $value = '"'.$value.'"';
        }

        return $value;
    }

    /**
     * Prompts you to run another command if condition is met.
     *
     * @param \Innoflash\EnvUpdater\EnvUpdater $envUpdater
     * @param \Closure $next
     *
     * @return void
     */
    protected function scanEnvFile(EnvUpdater $envUpdater, \Closure $next)
    {
        if (in_array($this->getVariable(),
                $envUpdater->getEntries()->keys()->toArray()) !== $this->variableShouldExist()) {
            $presenceMessage = $this->variableShouldExist() ? 'does not' : 'already';
            $useNextCommand = $this->confirm('The .env '.$presenceMessage.' have the '.$this->getVariable().PHP_EOL.'Would you wanna run "php artisan '.$this->nextCommand().'"?');

            if ($useNextCommand) {
                $this->call($this->nextCommand(), [
                    '--silent' => $this->option('silent'),
                ]);
            }
        } else {
            $next($envUpdater);
        }
    }
}
