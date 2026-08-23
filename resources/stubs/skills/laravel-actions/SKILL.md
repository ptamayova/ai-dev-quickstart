---
name: laravel-actions
description: Build Laravel application behavior with thin HTTP boundaries and focused Action classes.
---

# Laravel Actions

## Goal

Keep business behavior reusable and testable without introducing repository or service layers by default.

## Workflow

1. Validate HTTP input with a Form Request.
2. Put the use case in a verb-named `app/Actions/**/**Action.php` class with one public `handle()` method.
3. Inject collaborators through constructor-promoted `private readonly` properties.
4. Query Eloquent models directly and wrap multi-write operations in `DB::transaction()`.
5. Let controllers, commands, and jobs translate their boundary input, call the Action, and format the response.
6. Add a feature test when the Action uses Laravel infrastructure or the database; use a unit test only for pure logic.

## References

- `AGENTS.md`
- `app/Actions/`
- `app/Http/Controllers/`
- `app/Http/Requests/`
- `tests/Feature/`

## Anti-patterns

- Do not put business queries or third-party calls in controllers.
- Do not add a repository around Eloquent without a real interchangeable data-source boundary.
- Do not mock Eloquent models; exercise database behavior in a feature test.
