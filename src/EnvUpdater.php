<?php

namespace Innoflash\EnvUpdater;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\File;
use League\Flysystem\FileNotFoundException;

class EnvUpdater
{
    private $entries = null;

    public function __construct()
    {
        if (! in_array(app()->environment(), config('env-updater.production_tags'))
            || (bool) config('env-updater.show_in_production')) {
            $envFile = base_path('.env');
            if (! File::exists($envFile)) {
                throw new FileNotFoundException('The .env file is not found. Consider running "cp .env.example .env"');
            }

            $fileData = File::get($envFile);
            $this->entries = collect(explode(PHP_EOL, $fileData))
                ->reject(function ($val) {
                    return empty($val);
                })->mapWithKeys(function ($val) {
                    [$key, $value] = explode('=', $val);

                    return [$key => $value];
                });
        } else {
            throw new AuthorizationException('You are not allowed to see the .env file in production');
        }
    }

    /**
     * @return \Illuminate\Support\Collection|null
     */
    public function getEntries(): ?\Illuminate\Support\Collection
    {
        return $this->entries;
    }
}
