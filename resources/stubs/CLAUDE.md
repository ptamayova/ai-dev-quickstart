# Laravel + Inertia Architecture & Testing Guidelines

## Core Philosophy

This project prioritizes **SOLID**, **KISS**, and **YAGNI**. Keep code explicit, focused, and easy to change.

1. Give each module, class, and function one clear responsibility.
2. Prefer named, explicit behavior over hidden state or magic values.
3. Validate inputs at boundaries and fail with useful errors.
4. Let names communicate intent; keep code clearer than the comments needed to explain it.
5. Leave each change at least as simple as the code you found.

## Architecture

Use pragmatic Laravel Actions to isolate business logic.

- Keep controllers responsible for HTTP concerns: validate with Form Requests, call Actions, and return Inertia or JSON responses.
- Put business logic in single-purpose classes under `app/Actions`, with a `handle()` method and constructor-injected dependencies.
- Use `DB::transaction()` for multi-model operations that must succeed or fail together.
- Use Eloquent directly in Actions. Prefer model scopes for reusable query constraints; do not add repositories without a concrete need.

## Testing Strategy

Test the behavior that matters at the cheapest reliable level.

- Write Pest unit tests for pure logic that does not need the database.
- Write Pest feature tests for Actions, HTTP endpoints, persistence, events, and jobs using a real test database.
- Mock third-party APIs with Laravel fakes or interface bindings, but do not mock Eloquent models.
- Keep browser tests limited to critical end-to-end journeys and important failure states.
