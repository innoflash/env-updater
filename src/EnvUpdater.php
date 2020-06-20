<?php

namespace Innoflash\EnvUpdater;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use League\Flysystem\FileNotFoundException;

class EnvUpdater
{
    private $entries = null;
    private $envFileData;
    private $envOriginalEntries;

    public function __construct()
    {
        if (! in_array(app()->environment(), config('env-updater.production_tags'))
            || (bool) config('env-updater.show_in_production')) {
            $envFile = base_path('.env');
            if (! File::exists($envFile)) {
                throw new FileNotFoundException('The .env file is not found. Consider running "cp .env.example .env"');
            }

            $this->envFileData = File::get($envFile);

            $this->envOriginalEntries = collect(explode(PHP_EOL, $this->envFileData));

            $this->entries = $this->envOriginalEntries->reject(function ($val) {
                return empty($val);
            })->mapWithKeys(function ($val) {

                [$key, $value] = explode('=', $val);

                return [$key => $value];
            })->sortBy(function ($val, $key){
                return $key;
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

    /**
     * @return string
     */
    public function getEnvFileData(): string
    {
        return $this->envFileData;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getEnvOriginalEntries(): \Illuminate\Support\Collection
    {
        return $this->envOriginalEntries;
    }

    /**
     * Update the .env file.
     *
     * @param \Illuminate\Support\Collection $items
     *
     * @return bool|int
     */
    public function writeEnvFile(Collection $items)
    {
        $data = "";

        foreach ($items->toArray() as $key => $value) {
            $keys = $items->keys()->toArray();
            $index = array_search($key, $keys);

            if ($index != 0) {
                $prevPrefix = Str::of($keys[$index - 1])->before('_');
                $currentPrefix = Str::of($keys[$index])->before('_');

                if (strcmp($prevPrefix, $currentPrefix) != 0) {
                    $data .= PHP_EOL;
                }
            }
            $data .= $key.'='.$value.PHP_EOL;
        }

        return File::put(base_path('.env'), $data);
    }
}
