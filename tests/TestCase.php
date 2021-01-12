<?php

namespace Tests;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Http\Request;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DispatchesJobs;

    /**
     * @var Request
     */
    protected $request;

    public function setUp(): void
    {
        parent::setUp();

        $this->request = new Request();

        $this->runMigrationsAndSeed();
    }

    /**
     * Run migrations together with seeding
     */
    private function runMigrationsAndSeed()
    {
        if (env('DB_DATABASE') === ':memory:') {
            $this->artisan('migrate', ['--seed' => true]);
        }
    }
}
