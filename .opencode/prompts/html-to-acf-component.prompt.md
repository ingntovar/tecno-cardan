---
description: Integrate supplied HTML as an ACF page-builder component in the Tecno Cardan WordPress theme, with a dry-run approval gate.
agent: Sdd-Orchestrator
---

# HTML to ACF Component

Integrate the supplied HTML into the existing WordPress theme architecture as a reusable ACF page-builder component. This is an implementation prompt, but edits are forbidden until the dry-run proposal is explicitly approved by the user.

## Required Input

The caller must provide this structured input. Do not infer missing required values.

```yaml
html: "path/to/source.html or raw HTML string"
component_name: "Human-readable component name"
component_slug: "kebab-case-slug"
target_page: "WordPress page/template identifier"
visual_reference: "optional/path/to/reference.png"
```

- `html` is required and may be a file path or an explicitly supplied HTML string.
- `component_name` is required and must be descriptive.
- `component_slug` is required, lowercase, kebab-case, and safe for PHP/ACF identifiers.
- `target_page` is required. If it is missing, empty, ambiguous, or does not identify one concrete page, **STOP immediately**, explain the missing input, and do not inspect or edit implementation files.
- `visual_reference` is optional. If present, inspect it during exploration and use it only as visual guidance; do not invent content that is not supported by the HTML or reference.

If the input is not supplied in the structure above, ask the user to provide it in that structure and stop.

## Mandatory Context

Before proposing implementation, load and follow these local skills:

- `wp-acf-page-builder`
- `wp-theme-architecture`
- `wp-frontend-js` when the component includes or changes JavaScript behavior

Inspect the actual repository and existing conventions before deciding file names, fields, routing, normalizers, templates, SCSS entry points, or ACF JSON location. Do not assume that a similarly named component or page has the same contract.

## Safety and Approval Gate

1. Validate the structured input and stop if `target_page` is missing.
2. Explore read-only: inspect the HTML, optional visual reference, target page, current page-builder implementation, ACF Local JSON groups, existing components, normalizers, router, and SCSS architecture.
3. Produce a dry-run proposal before any edit. Include:
   - files to create or update;
   - proposed ACF field contract and defaults;
   - target-page placement and why it is limited to that page;
   - router, normalizer, template, and SCSS integration;
   - risks, assumptions, validation commands, and files explicitly out of scope.
4. Ask for explicit approval. Treat only a clear approval such as `approve`, `approved`, or an equivalent affirmative response as authorization.
5. Until approval, do not create, edit, delete, rename, or format project files; do not generate ACF JSON; and do not run implementation commands.

## Implementation Requirements After Approval

### ACF contract

- Create the ACF Local JSON through the repository's existing mechanism and location. The agent creates and validates this file; the user must not be asked to manually write JSON.
- Follow the existing flexible-content `components` layout contract and current naming conventions.
- Define only fields required by the HTML and visual behavior. Prefer existing reusable field groups or patterns where they exist.
- Include appropriate field types, names, labels, required flags, defaults, return formats, and conditional logic.
- Ensure the new layout is available to the page builder without weakening existing layouts.
- Validate that the JSON is valid and that field names match every PHP access.

### Defensive data handling

- Guard ACF access with the repository's established `function_exists('get_field')`, `is_array()`, `isset()`, and `empty()` patterns where applicable.
- Use an explicit `post_id` when reading page fields.
- Normalize strings, booleans, media, links, and repeated values in the builder/normalizer layer.
- Return an empty section or safe fallback when required content is absent; never emit broken markup or warnings.
- Use the `lff_` prefix for new custom PHP functions and preserve the theme's existing function responsibilities.

### Page-builder integration

- Add or extend the ACF layout in the existing Local JSON flexible content group.
- Add a dedicated normalizer in `includes/components/page-builder/normalizer/` when the component has non-trivial mapping.
- Register the normalizer in the normalizer barrel and map the `acf_fc_layout` explicitly in the component router.
- Return the stable shape `array('component' => '...', 'args' => array(...))`.
- Render presentational markup in `pages/components/{component_slug}.php` using normalized `$args` only.
- Integrate the component into the explicit `target_page` instance only. Do not make it appear on every page, alter unrelated pages, or silently add it to a global fallback.
- Keep `pages/frontpage.php` and entry templates thin. Use the existing page assembler and builder boundaries.
- **Never call `get_field()` from `pages/components/*.php`, `pages/frontpage.php`, or other presentational templates.**

### Markup, security, and accessibility

- Preserve the semantic structure and behavior of the supplied HTML while adapting class names only when required by project conventions.
- Escape output according to context: `esc_html()` for text, `esc_attr()` for attributes, `esc_url()` for URLs, and an explicitly justified safe HTML strategy for approved rich text.
- Sanitize or validate dynamic URLs, IDs, classes, and media values before output.
- Preserve or improve labels, heading hierarchy, keyboard behavior, alt text, and accessible names without inventing content.
- Do not hardcode editable content in PHP templates.

### Styles and scripts

- Migrate inline `<style>` rules and component-specific CSS from the HTML into the repository's SCSS architecture.
- Put styles in the appropriate existing SCSS partial and register/import that partial through the established SCSS entry point. Do not edit generated CSS directly.
- Reuse existing variables, mixins, breakpoints, and component patterns before adding new tokens.
- Migrate inline scripts or behavior into the existing JavaScript architecture only when present and necessary; do not introduce a bundler, framework, or dependency.
- Do not use inline styles except for an existing, justified dynamic value pattern such as a safely escaped background URL, and prefer the repository's established approach.

## Verification

After approved implementation:

- Run `php -l` against every changed PHP file.
- Validate every changed ACF Local JSON file with a JSON parser and inspect its schema shape.
- Check that the target page is the only page receiving the new instance.
- Check for `get_field()` in presentational templates and remove any new occurrences.
- Review escaping and defensive guards for every dynamic value.
- Review `git diff` and `git status --short` and report the exact changed files.
- Never run a build, watcher, asset compilation, package install, deployment, or database migration. If generated assets would normally be rebuilt, report that fact instead of building.

## Expected Final Response

Report:

- the approved implementation summary;
- the ACF Local JSON file created or updated;
- the exact target-page integration;
- files changed;
- validation commands and results;
- any unresolved visual or content assumptions;
- confirmation that no build was run.

## Usage

Run the project command with the structured payload as its argument. The command
loads this prompt; do not pass this prompt's path as the command argument.

Recommended invocation:

```text
/acf-wiring {"html":"/absolute/path/component.html","component_name":"Pricing table","component_slug":"pricing-table","target_page":"pricing","visual_reference":"/absolute/path/pricing.png"}
```

The command must pass the payload to this prompt, perform the dry-run, and wait for explicit approval before any edit. If `target_page` is missing, the agent must stop without changes.
