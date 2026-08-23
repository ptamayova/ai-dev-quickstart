<?php

declare(strict_types=1);

namespace AiDevQuickstart\AiDevQuickstart\Tests;

use AiDevQuickstart\AiDevQuickstart\AiDevQuickstartServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public string $applicationPath;

    protected function getPackageProviders($app): array
    {
        return [
            AiDevQuickstartServiceProvider::class,
        ];
    }
}
