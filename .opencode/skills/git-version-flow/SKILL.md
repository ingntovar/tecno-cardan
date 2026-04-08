---
name: git-version-flow
description: >
  Git branch and commit guidance for La Fonda using the repo's current conventional
  prefixes and recent history. Trigger: When starting a new change, planning branch
  names, reviewing git status/diff, or preparing commits in this repo.
license: Apache-2.0
metadata:
  author: gentleman-programming
  version: "1.0"
---

## When to Use

- Start any new feature, fix, or maintenance task in this repo.
- Choose a branch name or write a commit message before committing.
- Review the working tree before a commit or optional push.

## Critical Patterns

- Before starting each new change, create a fresh branch whose prefix matches the work type: `feat/...`, `fix/...`, or `chore/...`.
- Branch names use lowercase words joined by hyphens, for example `feat/live-search-overlay`, `fix/search-modal-scroll`, `chore/update-agent-docs`.
- Commit messages follow the same conventional prefix format: `feat: ...`, `fix: ...`, `chore: ...`.
- Recent repo history confirms this convention is already in use: `chore: new directory for UI Mockups 2`, `chore: new directory for UI Mockups`, `feat: refine single and single-filosofo page prototypes`, `feat: initial commit - home and pagina de autor mocked up`.

## Choose the Prefix

| Prefix | Use when | Example |
|--------|----------|---------|
| `feat` | Adding or expanding user-visible functionality, UI, or behavior | `feat: add live search overlay` |
| `fix` | Correcting broken behavior, regressions, layout bugs, or JS errors | `fix: prevent search modal body scroll` |
| `chore` | Maintenance work, docs, mockups, cleanup, or workflow updates without a user-facing feature/fix | `chore: update agent git workflow skill` |

## Commands

```bash
# create and switch to a branch before starting work
git checkout -b feat/live-search-overlay

# review what changed
git status --short
git diff
git diff --staged

# stage and commit
git add path/to/file path/to/other-file
git commit -m "feat: add live search overlay"

# optionally publish the branch
git push -u origin feat/live-search-overlay
```

## Practical Flow

1. Pick `feat`, `fix`, or `chore` based on the intent of the change.
2. Create the branch before editing files.
3. Review `git status --short` and `git diff` before committing.
4. Commit with the matching prefix and a short, specific message.
5. Push only when needed for backup, collaboration, or a pull request.

## Resources

- `AGENTS.md` - repo-wide workflow and editing constraints.
- `.agent/skills/la-fonda-frontend-js/SKILL.md` - example of the local skill format already used in this repo.
