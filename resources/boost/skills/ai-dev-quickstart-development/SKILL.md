---
name: ai-dev-quickstart-development
description: >
  Configure and apply the Ai Dev Quickstart package in Laravel applications.
license: MIT
metadata:
  author: mdecode
---

# Ai Dev Quickstart

Use this skill when a Laravel application needs to integrate the Ai Dev Quickstart package.

## Primary Goal

- install a customizable, application-owned baseline for AI rules, Laravel development skills, quality tooling, and Docker services

## Workflow

### 1. Inspect the Laravel application

- confirm the working directory contains `artisan` and `composer.json`
- inspect existing `AGENTS.md`, `.agents/skills`, Docker, Rector, Pint, and PHPStan files before installing
- preserve app-specific Composer constraints and scripts

### 2. Install the baseline

```bash
composer require --dev mdecode/ai-dev-quickstart
php artisan ai-dev-quickstart:install
```

The command preserves existing resource files and existing Composer values. It installs missing development dependencies and scripts, then runs Composer.

Use `--no-composer` only when dependencies must be installed later. Use `--force` only when replacing the generated resource files is intentional.

### 3. Customize the installed files

- adapt `AGENTS.md` to the application's actual architecture
- add or refine skills under `.agents/skills/`
- adjust `docker-compose.yml` and `docker/laravel/Dockerfile` for local infrastructure
- tune `phpstan.neon`, `pint.json`, and `rector.php` as the application evolves

### 4. Validate the application

Run the narrow command needed during development, then run `composer test`. Use `docker compose up --build` to validate the FrankenPHP and PostgreSQL setup.

## Rules, References, and Templates

Read before executing:

- `README.md`
- the consuming application's `AGENTS.md`
- the consuming application's `.agents/skills/`
- the consuming application's `composer.json`

## Examples

- scaffold without network access: `php artisan ai-dev-quickstart:install --no-composer`, review the diff, then run `composer update`
- intentionally reset only package-generated resources: commit current customizations, then run `php artisan ai-dev-quickstart:install --force`

## Anti-patterns

- do not document package internals here; keep the skill focused on adoption in Laravel apps
- do not assume `--force` merges customized files; it replaces package-generated resource destinations
- do not delete existing application-specific Composer scripts or constraints
- do not treat the generated rules and tool configuration as immutable vendor files
