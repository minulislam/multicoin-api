<?php

namespace Multicoin\Api\Tests;

use Multicoin\Api\Facades\Multicoin;
use Multicoin\Api\MulticoinServiceProvider;
use Orchestra\Testbench\TestCase as Testbench;

abstract class TestbenchTestCase extends Testbench
{
    /**
     * Setup before each test.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }
    /**
     * Tear down after each test.
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
    }
    /**
     * Tell Testbench to use this package.
     * @param  $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [MulticoinServiceProvider::class];
    }
    protected function getPackageAliases($app)
    {
        return [
            'multicoin' => Multicoin::class,
        ];
    }
}
