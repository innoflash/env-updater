<?php

namespace Innoflash\EnvUpdater;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Innoflash\EnvUpdater\Skeleton\SkeletonClass
 */
class EnvUpdaterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'env-updater';
    }
}
