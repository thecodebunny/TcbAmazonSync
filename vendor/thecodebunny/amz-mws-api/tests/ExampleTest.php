<?php

namespace Thecodebunny\AmzMwsApi\Tests;

use Orchestra\Testbench\TestCase;
use Thecodebunny\AmzMwsApi\AmzMwsApiServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [AmzMwsApiServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
