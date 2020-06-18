<?php

namespace Innoflash\EnvUpdater\Tests;

use Orchestra\Testbench\TestCase;
use Innoflash\EnvUpdater\EnvUpdaterServiceProvider;

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
