<?php

namespace Innoflash\EnvUpdater\Tests;

use Innoflash\EnvUpdater\EnvUpdaterServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [EnvUpdaterServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
