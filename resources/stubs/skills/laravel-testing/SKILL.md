---
name: laravel-testing
description: Test Laravel application behavior with Pest at the cheapest level that gives confidence.
---

# Laravel Testing

## Goal

Cover application-owned behavior through public boundaries while keeping the suite fast and maintainable.

## Workflow

1. Choose a unit test for pure calculations, transformations, and rules with no framework infrastructure.
2. Choose a feature test for Actions using Eloquent, HTTP endpoints, jobs, events, mail, and other Laravel integrations.
3. Use real models and the test database; fake only external systems with Laravel fakes or an interface binding.
4. Assert observable output, response, database state, or dispatched work rather than implementation details.
5. Keep browser tests to the small set of critical journeys and key failure states.
6. Run the focused Pest test while iterating, then run `composer test` before finishing.

## References

- `AGENTS.md`
- `tests/Unit/`
- `tests/Feature/`
- `phpunit.xml`
- `composer.json`

## Anti-patterns

- Do not test Laravel framework behavior.
- Do not mock the database or Eloquent models.
- Do not use an end-to-end test when a feature test proves the same behavior.
