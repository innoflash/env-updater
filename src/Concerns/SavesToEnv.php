<?php

namespace Innoflash\EnvUpdater\Concerns;

use Illuminate\Support\Str;

trait SavesToEnv
{
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

        if (! $this->argument('value')) {
            $useBlank = $this->confirm('Looks like you didn`t set a value for this variable. Do you want to use a blank for this?');
            if ($useBlank) {
                return '';
            } else {
                $value = $this->ask('Please enter the value you want to set for '.$value);
            }
        }

        if (Str::contains($this->getValue(), ' ')) {
            $value = '"'.$value.'"';
        }

        return $value;
    }
}
