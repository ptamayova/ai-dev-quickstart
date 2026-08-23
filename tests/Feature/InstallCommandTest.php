<?php

declare(strict_types=1);

use Illuminate\Filesystem\Filesystem;

beforeEach(function () {
    $this->applicationPath = sys_get_temp_dir().'/ai-dev-quickstart-'.bin2hex(random_bytes(8));

    mkdir($this->applicationPath, 0755, true);

    file_put_contents($this->applicationPath.'/composer.json', json_encode([
        'name' => 'example/application',
        'require-dev' => [
            'fakerphp/faker' => '^1.24',
        ],
        'scripts' => [
            'existing' => 'php artisan about',
        ],
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES).PHP_EOL);

    $this->app->setBasePath($this->applicationPath);
});

afterEach(function () {
    (new Filesystem)->deleteDirectory($this->applicationPath);
});

it('installs editable development resources and configures composer', function () {
    $this->artisan('ai-dev-quickstart:install', ['--no-composer' => true])
        ->expectsOutputToContain('AI development quickstart installed')
        ->assertSuccessful();

    expect($this->applicationPath.'/AGENTS.md')->toBeFile()
        ->and($this->applicationPath.'/.agents/skills/laravel-actions/SKILL.md')->toBeFile()
        ->and($this->applicationPath.'/.agents/skills/laravel-testing/SKILL.md')->toBeFile()
        ->and($this->applicationPath.'/docker-compose.yml')->toBeFile()
        ->and($this->applicationPath.'/docker/laravel/Dockerfile')->toBeFile()
        ->and($this->applicationPath.'/phpstan.neon')->toBeFile()
        ->and($this->applicationPath.'/pint.json')->toBeFile()
        ->and($this->applicationPath.'/rector.php')->toBeFile();

    expect(file_get_contents($this->applicationPath.'/AGENTS.md'))
        ->toBe(file_get_contents(__DIR__.'/../../resources/stubs/AGENTS.md'));

    $composer = json_decode(
        (string) file_get_contents($this->applicationPath.'/composer.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    expect($composer['require-dev'])
        ->toMatchArray([
            'driftingly/rector-laravel' => '^2.3',
            'fakerphp/faker' => '^1.24',
            'larastan/larastan' => '^3.9',
            'pestphp/pest' => '^4.7',
            'pestphp/pest-plugin-laravel' => '^4.1',
            'pestphp/pest-plugin-type-coverage' => '^4.0',
            'rector/rector' => '^2.4',
        ])
        ->and($composer['scripts']['existing'])->toBe('php artisan about')
        ->and($composer['scripts'])->toHaveKeys([
            'lint',
            'lint:check',
            'test:type-coverage',
            'test:unit',
            'test:lint',
            'test:types',
            'test',
        ]);
});

it('preserves customized files and composer values unless forced', function () {
    file_put_contents($this->applicationPath.'/AGENTS.md', 'custom rules');

    $composer = json_decode(
        (string) file_get_contents($this->applicationPath.'/composer.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );
    $composer['require-dev']['rector/rector'] = '^2.5';
    $composer['scripts']['lint'] = 'custom lint';
    file_put_contents(
        $this->applicationPath.'/composer.json',
        json_encode($composer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR).PHP_EOL,
    );

    $this->artisan('ai-dev-quickstart:install', ['--no-composer' => true])
        ->assertSuccessful();

    $composer = json_decode(
        (string) file_get_contents($this->applicationPath.'/composer.json'),
        true,
        flags: JSON_THROW_ON_ERROR,
    );

    expect(file_get_contents($this->applicationPath.'/AGENTS.md'))->toBe('custom rules')
        ->and($composer['require-dev']['rector/rector'])->toBe('^2.5')
        ->and($composer['scripts']['lint'])->toBe('custom lint');

    $this->artisan('ai-dev-quickstart:install', [
        '--force' => true,
        '--no-composer' => true,
    ])->assertSuccessful();

    expect(file_get_contents($this->applicationPath.'/AGENTS.md'))
        ->toBe(file_get_contents(__DIR__.'/../../resources/stubs/AGENTS.md'));
});

it('fails loudly when the application composer manifest is invalid', function () {
    file_put_contents($this->applicationPath.'/composer.json', '{invalid');

    $this->artisan('ai-dev-quickstart:install', ['--no-composer' => true])
        ->expectsOutputToContain('Unable to update composer.json')
        ->assertFailed();
});
