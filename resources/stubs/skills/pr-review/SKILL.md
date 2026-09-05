---
name: pr-review
description: Review a pull request diff for material Laravel behavior, architecture, security, data, and regression risks.
---

# Pull Request Review

Use this skill when the user asks for a pull-request review, merge-readiness assessment, or code review before merge.

## Goal

Review the proposed diff—not uncommitted local work—and report only verified, actionable findings that materially affect correctness, security, data safety, or the architecture established by the application's `AGENTS.md`.

## Scope

- Read-only: do not edit code, push, change GitHub state, post comments, or run formatting tools.
- Review code behavior and design, not Pint, Rector, PHPStan, test execution, or CI status.
- Use the open PR for the current branch when available. If there is no open PR, review the user-provided base diff or state that an open PR is required.
- If the working tree is dirty, note that the review covers the PR diff only and exclude local changes.

## Workflow

1. Read the PR description for intent, stated risks, deployment steps, and QA context; do not repeat it in the review.
2. Resolve the base and head revisions and inspect the full `base...head` diff and changed-file list. Read surrounding code and relevant `AGENTS.md` files where needed to verify a concern.
3. Apply the core checks to every changed behavior path:
   - Correctness: validation, null/error handling, state transitions, transactions for related writes, idempotency for retried jobs, and authorization.
   - Security: access control, tenant ownership, mass assignment, raw SQL, untrusted output, uploads, paths, URLs, and secrets.
   - Performance: N+1 queries, unbounded reads, expensive work in HTTP/UI render paths, and synchronous external I/O.
   - Clean code: misleading names, deeply nested or multi-purpose methods, and duplicated business rules only when divergence can cause incorrect behavior.
4. Route relevant changed files through the checks below.
5. Report at most eight highest-impact findings. Omit low-confidence hypotheticals, style nits, untouched legacy code, and non-material edge cases.

## Laravel architecture checks

The installed root `AGENTS.md` defines the architecture. For this quickstart, verify that changed code follows these boundaries:

- Controllers validate via Form Requests, delegate to focused Actions, and return the appropriate HTTP, Inertia, or API response. Do not accept business workflows, complex Eloquent queries, or third-party calls in controllers.
- Actions live under `app/Actions`, have one clear responsibility and a `handle()` method, inject collaborators through constructor-promoted `private readonly` properties, use Eloquent directly, and wrap multi-write operations in `DB::transaction()`.
- Do not demand repositories around Eloquent unless the change introduces a genuine interchangeable data-source boundary.
- Tests exercise database-backed Actions through feature tests with real models and a test database; only external systems should be faked or mocked.

## Conditional checks

| Changed area | Verify |
| --- | --- |
| `database/migrations/**` or schema changes | reversible/safe migration, populated-table defaults or backfills, indexes for new hot queries, and application alignment |
| `app/Http/**`, `routes/**`, policies, auth | Form Request validation, authorization, ownership, and safe responses |
| `app/Actions/**`, jobs, events | focused orchestration, transactions, retries/idempotency, exceptions, and queue-safe work |
| models or Eloquent queries | scopes for reusable constraints, N+1/unbounded reads, casts, guarded writes, and changed relationship behavior |
| `config/**`, `composer.*`, `package.*` | configuration documentation and that newly added direct dependencies are actually used |
| Docker, Compose, or GitHub workflows | secrets, permissions, required environment documentation, and local/production compatibility |
| `tests/**` or changed behavior | regression coverage for material new validation, persistence, authorization, and workflow behavior |

## Report format

```markdown
# PR Review Report

## Review scope

- **Reviewed:** `<base>...<head>`
- **Coverage:** <all changed files reviewed, or name any excluded file and why>

## Findings

None

#### Short, specific finding title

- **Category:** Correctness | Security | Architecture | Database | Performance | Tests | Infrastructure
- **Location:** `path/to/file.php:42`
- **Evidence:** <what the diff and surrounding code prove>
- **Impact:** <material consequence>
- **Required fix:** <concrete correction>
- **Verification:** <how to prove it is resolved>

## Advisories

None

## Verdict

**Ready** | **Ready with fixes** | **Not ready**

<one concise explanation>
```

Use **Ready** when there are no findings or advisories; **Ready with fixes** when only non-blocking maintainability advisories remain; otherwise use **Not ready**. Advisories are limited to meaningful maintainability concerns, such as a changed class taking on unrelated responsibilities; they never substitute for a concrete finding.

## Anti-patterns

- Reporting formatting, static-analysis, test-run, or CI failures as code-review findings.
- Enforcing Clean Architecture, repositories, Livewire, or a project-specific storage pattern when the consuming application's `AGENTS.md` does not require it.
- Calling out issues without a concrete location, evidence, material impact, and actionable fix.
- Reviewing uncommitted work as though it were part of the pull request.
