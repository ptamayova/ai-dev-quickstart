---
name: requirements-to-gh-issue
description: Turn a requirement into a repo-grounded, ready-to-paste GitHub issue before implementation starts.
---

# Requirements to GitHub Issue

Use this skill when the user provides a feature request, ticket, briefing, or task and wants to understand its effect on the application or turn it into a GitHub issue.

## Goal

Produce a concise, implementable issue that distinguishes existing behavior from new work without inventing product decisions or implementation details.

## Workflow

1. Read the requirement carefully and identify the affected users, outcomes, constraints, and unanswered business decisions.
2. Inspect the repository for related routes, controllers, Actions, models, requests, Inertia pages or API resources, tests, and documentation. Read the most relevant matches.
3. Classify the request as an enhancement, a new capability, or a bug fix based on evidence from the repository.
4. Before drafting, resolve up to three material business questions. Prefer the available structured question tool; otherwise ask one concise question at a time. Always allow a `TBD` answer and do not re-ask it.
5. Draft the complete issue in one pass. If the repository has an issue template, use its headings and front matter. Otherwise use the template below.
6. Do not write code or create an issue unless the user explicitly asks. When asked to create one, use the repository's existing GitHub labels, project conventions, and issue templates; never assume a specific project, label, or status.

## Default issue template

```markdown
## Overview

**Current state:** <what the repository demonstrably does today>

**Proposal:** <what changes and whether it is an enhancement, new capability, or fix>

## Goal

<the user or business outcome>

## Open questions

- <decision and its resolved answer, or **TBD**>

## Success criteria

- [ ] <observable outcome not already implemented>

## Proposed solution

<high-level shape of the change; no file names, class names, schema, or code>

## Technical considerations

- <only material risks, compatibility constraints, or dependencies>
```

Omit **Open questions** when there are none and **Technical considerations** when no material risk is evidenced.

## Rules

- Ground the current-state statement in repository evidence, not the wording of the request.
- Keep the issue product-oriented. Mention the Action-based Laravel architecture only when it materially constrains scope; do not turn the issue into a technical specification.
- Keep success criteria measurable and exclude behavior that already works.
- Use plain, warm language. Do not fabricate owners, dates, estimates, labels, dependencies, or answers.

## References

- `AGENTS.md`
- `.github/ISSUE_TEMPLATE/`
- `routes/`
- `app/Actions/`
- `app/Http/`
- `tests/`

## Anti-patterns

- Drafting an issue before checking what already exists.
- Asking technical implementation questions instead of product and scope questions.
- Creating a GitHub issue, assigning labels, or adding it to a project without explicit instruction.
- Including code, database schemas, or file-level implementation plans in a planning issue.
