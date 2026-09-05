---
name: pr-description
description: Draft a concise, evidence-based pull request description from the current branch changes.
---

# Pull Request Description

Use this skill when the user asks to write, prepare, or create a pull request.

## Goal

Give reviewers and QA a clear explanation of the branch's outcome, implementation shape, deployment needs, risks, and reproducible verification steps.

## Workflow

1. Resolve the base branch: use the user-provided base, then `main`, then `master`.
2. Inspect the branch and all proposed changes: `git status -sb`, `git log --oneline <base>...HEAD`, `git diff <base>...HEAD --stat`, and the full diff. Inspect changed files when the patch alone is ambiguous.
3. If uncommitted work may be included, inspect staged and unstaged diffs separately. Do not imply it is part of the PR unless the user confirms it will ship.
4. Infer only what the evidence supports: user-facing behavior, Action/controller/request changes, database migrations, seeders, configuration, assets, tests, and operational impact.
5. Draft the title and description using the template below.
6. Push or create a GitHub pull request only when the user explicitly asks. Return its URL after creation.

## Template

```markdown
## Summary

<one or two sentences: what changed, for whom, and the outcome>

## How we solved it

<two to four sentences on the high-level approach. Mention Laravel boundaries only when useful: Form Request, Action, controller, Eloquent, job, or UI.>

### What we implemented

- <concrete, shippable item>

### Deploy checklist

- [ ] <evidence-based deployment step>

### Risks and implications

- <real compatibility, authorization, data, performance, or operational risk>

## QA

- [ ] <specific happy-path verification>
- [ ] <specific validation, error, or regression verification>
```

Use `- [ ] Merge and deploy as usual (no migrations, seeders, or configuration changes).` when there are no special deployment steps. State `Low risk: no schema change; backward compatible.` when that is supported by the diff.

## Title

- Use an imperative, specific title, preferably `feat(scope): ...`, `fix(scope): ...`, or `refactor(scope): ...`.
- Keep it to 72 characters where practical and make it match the actual change rather than the branch name.

## Rules

- Analyze the whole branch, not only the latest commit.
- Never invent migrations, environment variables, test results, screenshots, deploy steps, or QA coverage.
- Keep implementation bullets to user-meaningful deliverables, not a file inventory.
- For screenshots or recordings, add a section only when assets are supplied or the user asks for one.

## References

- `AGENTS.md`
- `composer.json`
- `database/migrations/`
- `tests/`

## Anti-patterns

- Pushing code or creating a PR without explicit user authorization.
- Generic claims such as "tested locally" without executable QA steps.
- Treating uncommitted local changes as already part of the pull request.
