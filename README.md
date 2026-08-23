<div align="center">
    <h1>Ai Dev Quickstart</h1>
</div>

<p align="center">
    <a href="https://packagist.org/packages/mdecode/ai-dev-quickstart"><img src="https://img.shields.io/packagist/v/mdecode/ai-dev-quickstart.svg?style=flat-square" alt="Packagist"></a>
    <a href="https://packagist.org/packages/mdecode/ai-dev-quickstart"><img src="https://img.shields.io/packagist/php-v/mdecode/ai-dev-quickstart.svg?style=flat-square" alt="PHP from Packagist"></a>
    <a href="https://packagist.org/packages/mdecode/ai-dev-quickstart"><img src="https://badge.laravel.cloud/badge/mdecode/ai-dev-quickstart?style=flat" alt="Laravel versions"></a>
    <a href="https://github.com/mdecode/ai-dev-quickstart/actions"><img alt="GitHub Workflow Status (main)" src="https://img.shields.io/github/actions/workflow/status/mdecode/ai-dev-quickstart/tests.yml?branch=main&label=Tests&style=flat-square"></a>
    <a href="https://packagist.org/packages/mdecode/ai-dev-quickstart"><img src="https://img.shields.io/packagist/dt/mdecode/ai-dev-quickstart.svg?style=flat-square" alt="Total Downloads"></a>
</p>

A quickstart package for configuring new Laravel applications with customizable AI development rules, skills, quality tools, and a FrankenPHP development environment.

## Installation

Install the package as a development dependency, then run its installer:

```bash
composer require --dev mdecode/ai-dev-quickstart
php artisan ai-dev-quickstart:install
```

The installer:

- copies `AGENTS.md` and the starter skills in `.agents/skills/` into your application;
- adds an editable FrankenPHP `Dockerfile` and Docker Compose services for Laravel and PostgreSQL;
- adds editable Pint, PHPStan/Larastan, and Rector configuration;
- adds the requested development packages and quality scripts to the application's `composer.json`;
- runs a targeted Composer update to install those development packages.

Existing files, package constraints, and scripts are preserved. Use `--force` when you intentionally want to replace generated resource files:

```bash
php artisan ai-dev-quickstart:install --force
```

For offline setup or CI tests, `--no-composer` updates `composer.json` without running Composer:

```bash
php artisan ai-dev-quickstart:install --no-composer
```

## Usage

All installed files belong to the consuming application and are intended to be customized. Re-running the installer does not replace those files unless `--force` is supplied.

### Docker

Start the FrankenPHP application and PostgreSQL services:

```bash
docker compose up --build
```

The application is available at `http://localhost:8000` by default. Set `APP_PORT` or the `DB_*` environment variables to customize the Compose services.

### Quality commands

```bash
# Apply Rector and Pint fixes
composer lint

# Check Rector and Pint without changing files
composer lint:check

# Run Pest type coverage
composer test:type-coverage

# Run Pest with exact test coverage
composer test:unit

# Run PHPStan/Larastan
composer test:types

# Run the complete PHP quality suite
composer test
```

The exact-coverage test command requires Xdebug, which is included in the generated FrankenPHP image.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Thank you for considering contributing to Ai Dev Quickstart! Please review our [contributing guide](.github/CONTRIBUTING.md) to get started.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [mdecode](https://github.com/mdecode)
- [All Contributors](../../contributors)

## License

Ai Dev Quickstart is open-sourced software licensed under the [MIT license](LICENSE.md).
