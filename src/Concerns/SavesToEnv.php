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
}
