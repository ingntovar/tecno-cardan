---
name: acf-json-db-sync
description: >
  Documents and implements a controlled ACF Local JSON to WordPress database
  synchronization workflow, including reusable field groups, cloned Page
  Builder fields, persisted IDs, approval gates, and deployment safety.
  Trigger: when adding, reviewing, or operating ACF JSON synchronization in a
  WordPress project.
license: Apache-2.0
metadata:
  author: gentleman-programming
  version: "1.0"
---

# ACF Local JSON to Database Sync

## When to Use

- When version-controlled ACF Local JSON must be applied to a site's database.
- When a project has reusable component field groups and a flexible-content
  Page Builder assembled from ACF clones.
- When synchronizing between environments with different WordPress post IDs.
- When designing an admin-only sync command, dry-run workflow, or deployment
  procedure for ACF field groups.
- When investigating duplicate field groups, stale database definitions, or
  JSON/database drift.

## Critical Patterns

### JSON is the schema source of truth

- Treat the repository's ACF JSON as the versioned schema contract.
- Treat the database as the environment-specific runtime copy, not as the
  canonical place to manually maintain field definitions.
- Configure both `acf/settings/load_json` and `acf/settings/save_json` to use a
  project-owned directory such as `includes/acf/json-sync/`.
- Review JSON changes as code: inspect keys, locations, clone references,
  field names, defaults, and `active` state before synchronization.
- Do not overwrite JSON from an environment casually. First decide whether the
  database contains an intentional schema change that must be exported and
  reviewed.

### Keep reusable component groups separate

Use separate JSON files for reusable component definitions and for the active
Page Builder group. A common arrangement is:

| Group | Purpose | Typical `active` value |
| --- | --- | --- |
| Component group | Defines fields for one reusable component | `false` |
| Page Builder group | Defines the `components` flexible content and page locations | `true` |

- `active: false` component groups are intentional when they are consumed by a
  Clone field. They are definitions, not necessarily admin-visible groups to
  assign directly to posts.
- Do not "fix" an inactive reusable group by making every group active. That
  can expose implementation fields in the editor and create duplicate editing
  surfaces.
- Keep component groups independently keyed and review their clone references
  whenever a component is renamed or moved.

### Preserve the Page Builder clone architecture

- The active Page Builder group owns the flexible content field, layout names,
  layout-level settings, and page locations.
- A layout can use Clone fields to reuse a component group's fields instead of
  duplicating their definitions inside the flexible content JSON.
- Keep the separation between schema and rendering: ACF defines data, while
  builders, normalizers, and templates decide how that data is assembled.
- Use stable field names and `acf_fc_layout` values. Renaming them is a data
  migration, not a cosmetic refactor.
- Before sync, verify that each clone target key exists in the JSON set and
  that the clone prefix/display settings match the component's expected data
  shape.

### Stable ACF keys are portable; database IDs are not

- `key` values such as `group_...` and `field_...` identify definitions across
  environments and must remain stable once committed.
- `ID` is a WordPress database post ID. It can differ between local, staging,
  and production, and should not be treated as a portable identifier.
- Do not copy a local field group's numeric `ID` into production JSON as if it
  were stable metadata.
- Do not identify a group by title alone. Titles can change and may collide.

### Resolve persisted IDs before updating an existing group

When applying JSON directly through ACF Pro, resolve the existing database
post by its stable key and inject its current ID before calling
`acf_update_field_group()`:

```php
$key = isset($field_group['key']) ? (string) $field_group['key'] : '';
$existing = acf_get_field_group_post($key);

if ($existing instanceof WP_Post) {
    if (!isset($existing->ID) || (int) $existing->ID <= 0) {
        return new WP_Error('invalid_acf_id', 'Existing ACF group has no valid ID.');
    }

    $field_group['ID'] = (int) $existing->ID;
}

$result = acf_update_field_group($field_group);
```

- Call `acf_get_field_group_post($key)` for every group, not only for the first
  synchronization.
- Validate that the returned ID is numeric and positive before updating.
- If no group exists, allow ACF to create it without inventing an environment
  ID; retain the stable JSON key.
- Abort on malformed JSON, missing keys, missing locations, invalid field
  arrays, or a non-array update result. A partial schema is worse than a
  visible failed sync.

## Controlled Synchronization Workflow

### 1. Inspect and normalize the input set

1. Locate the configured JSON directory.
2. Enumerate only the intended `*.json` files.
3. Parse every file before changing the database.
4. Validate `key`, `title`, `fields`, `location`, clone targets, and expected
   active state.
5. Build a plan classified as `create`, `update`, `unchanged`, or `invalid`.

Do not start mutating the database while still discovering invalid input. A
parse/validation pass should fail before the write pass.

### 2. Dry-run before approval

The default operation should be read-only and should report:

- JSON file and stable group key;
- existing database ID, if any;
- create/update/unchanged result;
- title and active-state changes;
- clone references and location changes;
- duplicate candidates that require manual review;
- exact files and records that would be affected.

Require explicit approval before the write pass. The approval gate belongs in
the orchestration workflow even if the low-level PHP function only performs
the already-approved synchronization.

### 3. Write idempotently

- Match by stable key, never by title or numeric ID.
- Running the same approved plan twice should converge to the same field-group
  definitions and should not create another copy.
- Count and report created and updated groups separately.
- Do not report success until each `acf_update_field_group()` call returns a
  valid result.
- Prefer an all-input validation pass before writes. If atomic transactions
  are unavailable, report that a failure can leave a partially applied set and
  provide the affected keys.

## Trigger and Authorization Constraints

If a web trigger is necessary, keep it narrow and explicit:

```php
add_action('admin_init', function () {
    if (!isset($_GET['sync-acf-from-json'])
        || $_GET['sync-acf-from-json'] !== 'true'
        || !current_user_can('manage_options')) {
        return;
    }

    // Run only an approved, validated plan here.
});
```

- Inspect the query var only inside an admin lifecycle hook, not on every
  front-end request.
- Require the exact expected value; do not treat any non-empty value as an
  instruction to mutate the database.
- Require an appropriate capability. `manage_options` is a common baseline,
  but projects should choose the narrowest capability that fits their roles.
- Use a nonce and a POST action for a production mutating UI. A query-var
  trigger is convenient for local/admin operations but is still a GET-shaped
  mutation and is vulnerable to accidental execution without nonce protection.
- Make the handler single-run per request and stop with a clear response.
- Never expose the trigger to unauthenticated users or run it from front-end
  rendering paths.

## Duplicate Cleanup Cautions

- Never delete a group only because its title resembles another group's title.
- Compare stable keys, field keys, locations, clone references, and the
  group's actual usage before proposing deletion.
- A duplicate may be an old definition still referenced by layouts or stored
  post data. Removing it can make existing content unreadable.
- Export or back up the relevant JSON and database state before cleanup.
- Prefer marking an obsolete group inactive and removing references in a
  separate, reviewed change. Delete only after confirming there are no
  references or migration requirements.
- Do not use a cleanup pass as a hidden side effect of ordinary synchronization.
  Creation/update and deletion need separate approval.

## Production and Deployment Tradeoffs

| Approach | Benefits | Risks / Cost |
| --- | --- | --- |
| ACF admin UI sync | Familiar and visible | Manual, easy to miss, harder to audit |
| Admin-only controlled endpoint | Repeatable and scriptable | Must secure the trigger and approval flow |
| Deployment hook/CLI command | Fits release automation | Requires environment access, backups, and rollback planning |
| Database migration | Explicit release artifact | More coupling to WordPress/ACF internals |

- Local and staging environments are good places to inspect a dry-run and
  approve the resulting plan.
- Production synchronization should be an explicit release step, not an
  accidental side effect of a normal page request.
- Decide whether production should load Local JSON automatically, synchronize
  on deployment, or keep the JSON as a review artifact and use a controlled
  command. Document the decision per project.
- Back up the database before production writes and record the JSON commit,
  operator, timestamp, result, and affected keys.
- Ensure ACF Pro is available before attempting `acf_update_field_group()` or
  `acf_get_field_group_post()`. Fail clearly if the API is unavailable.
- Do not assume a successful field-group update is a content migration. Existing
  post meta may still need a separate migration when field names, return
  formats, or layouts change.

## Validation Checklist

- [ ] The skill/project uses one documented JSON source directory.
- [ ] Every JSON file parses successfully.
- [ ] Every group has a stable `key`, title, fields, and location data.
- [ ] Component groups intentionally use `active: false` when they are clone
      definitions, and the Page Builder group has the intended active state.
- [ ] Every Clone field points to an existing stable group or field key.
- [ ] No environment-specific numeric database IDs are used as stable keys.
- [ ] Existing groups resolve through `acf_get_field_group_post()` before
      `acf_update_field_group()`.
- [ ] The dry-run identifies creates, updates, unchanged groups, and errors.
- [ ] Explicit approval is recorded before writes.
- [ ] Repeating the approved sync is idempotent and does not create duplicates.
- [ ] Duplicate cleanup is a separate reviewed operation.
- [ ] The trigger is admin-only, capability-checked, exact-match, and nonce
      protected when exposed as a mutating production action.
- [ ] PHP syntax and JSON structure are validated for every changed file.
- [ ] The resulting Page Builder layouts can be loaded and rendered in a safe
      test environment.
- [ ] No build, watcher, asset compilation, package install, deployment, or
      unrelated database migration is run as part of schema synchronization.

## Commands

Use project-specific paths and credentials; these examples are intentionally
generic:

```bash
# Validate all Local JSON files without changing the database.
for file in path/to/theme/includes/acf/json-sync/*.json; do
  php -r 'json_decode(file_get_contents($argv[1]), true, 512, JSON_THROW_ON_ERROR);' "$file"
done

# Syntax-check the synchronization code.
php -l path/to/theme/includes/acf/sync.php

# Inspect the proposed file set and keep generated assets untouched.
git status --short
git diff -- path/to/theme/includes/acf/json-sync path/to/theme/includes/acf
```

Do not run a build to validate ACF schema changes. If a project's normal
workflow would compile assets, report that as a separate follow-up instead of
running it during synchronization.

## Implementation Notes

- Keep the sync function separate from field-group definitions and from page
  rendering.
- Keep the JSON loading/saving filters small and deterministic.
- Keep the trigger wrapper responsible for authorization and response handling;
  keep the sync function independently testable with a prepared input set.
- Return structured results that identify affected keys, rather than only a
  human sentence, so a CLI, admin UI, or deployment tool can consume them.
- Document any project-specific field-group naming, locations, and rollback
  procedure in that project's own skill or runbook.
