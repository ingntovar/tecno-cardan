---
name: wp-theme-architecture
description: Architectural conventions for the La Fonda Filosófica WordPress theme, including template assembly, file responsibilities, naming rules, and page/component organization.
license: MIT
compatibility: opencode
---

# La Fonda WordPress Theme Architecture

## Purpose

This skill defines the architectural conventions for the La Fonda Filosófica WordPress theme.

The theme follows a modular structure based on:

- a central page assembler
- granular includes loaded from `functions.php`
- reusable page partials and components
- utility helpers separated from callbacks
- strict `lff_` function prefixes
- page composition through files stored inside `pages/`

Follow this skill whenever you add or modify theme code.

---

## Core Principles

### 1. Central Template Assembler

Pages must be assembled through a single function:

```php
function lff_assemble_template($pagename, $exclude_nav = false) {
  global $theme_dir;
  global $theme_dir_uri;

  if (!file_exists("$theme_dir/pages/$pagename.php")) {
    echo 'template file not found, was looking for: ' . $pagename;
    $pagename = 'status404';
  }

  include "$theme_dir/pages/partials/header.php";

  if (!$exclude_nav) {
    include "$theme_dir/pages/partials/nav.php";
  }

  include "$theme_dir/pages/$pagename.php";
  include "$theme_dir/pages/partials/footer.php";
}
````

Rules:

* Do not manually compose full pages in random template files.
* Do not duplicate header, nav, or footer logic.
* Always route page composition through `lff_assemble_template()`.

---

### 2. Function Naming Convention

All custom PHP functions must use the prefix:

```text
lff_
```

Examples:

* `lff_enqueue_assets()`
* `lff_register_cpts()`
* `lff_get_asset_url()`
* `lff_assemble_template()`

Rules:

* Never introduce unprefixed global helper names.
* Keep naming descriptive and consistent with the file responsibility.

---

### 3. Role of `functions.php`

`functions.php` must only bootstrap theme modules.

Example:

```php
require_once get_template_directory() . '/includes/assemble.php';
require_once get_template_directory() . '/includes/custom.php';
require_once get_template_directory() . '/includes/enqueue.php';
require_once get_template_directory() . '/includes/images.php';
require_once get_template_directory() . '/includes/init.php';
require_once get_template_directory() . '/includes/modify.php';
require_once get_template_directory() . '/includes/utils.php';
```

Rules:

* Do not place business logic directly in `functions.php`.
* Do not place template markup in `functions.php`.
* Use `functions.php` only as the composition root for includes.

---

## Includes Responsibilities

### `includes/assemble.php`

Responsibility:

* page composition logic
* loading global partials
* 404 fallback behavior

Use this file for:

* `lff_assemble_template()`
* helper logic directly tied to page assembly

Do not place in this file:

* CPT registration
* enqueue logic
* unrelated utilities

---

### `includes/custom.php`

Responsibility:

* custom hooks and callbacks
* theme behavior wiring

Use this file for:

* action callbacks
* filter callbacks
* custom WordPress behavior integrations

---

### `includes/enqueue.php`

Responsibility:

* enqueueing styles and scripts
* conditional asset loading

Use this file for:

* `wp_enqueue_style`
* `wp_enqueue_script`
* asset dependency registration

---

### `includes/images.php`

Responsibility:

* image sizes
* image-related hooks
* thumbnail behavior

Use this file for:

* `add_image_size`
* image support adjustments
* media formatting helpers related to images

---

### `includes/init.php`

Responsibility:

* theme setup
* CPT registration
* taxonomy registration
* theme supports

Use this file for:

* `after_setup_theme`
* `register_post_type`
* `register_taxonomy`
* `add_theme_support`

---

### `includes/modify.php`

Responsibility:

* overriding default WordPress behavior

Use this file for:

* removing or relocating default hooks
* altering archive behavior
* changing default rendering or flow

---

### `includes/utils.php`

Responsibility:

* pure reusable helper functions

Rules:

* utilities here must be reusable and side-effect-light
* utilities must not be WordPress callbacks unless there is a very strong reason
* utilities must not output markup directly unless explicitly designed as a rendering helper

---

## Page Architecture

### Template Entry Files

Entry template files must be minimal.

Example:

```php
$pagename = 'frontpage';
lff_assemble_template($pagename);
```

Rules:

* keep these files thin
* they should delegate real rendering to `pages/`
* they should not contain long markup blocks

---

### Pages Directory

All page markup must live in:

```text
pages/
```

Examples:

* `pages/frontpage.php`
* `pages/authors.php`
* `pages/temas.php`
* `pages/status404.php`

Rules:

* page files contain page-level structure
* page files may include components
* page files should not redefine global layout primitives

---

## Partials

Shared layout primitives must live in:

```text
pages/partials/
```

Examples:

* `header.php`
* `nav.php`
* `footer.php`

Rules:

* these are global partials
* do not duplicate them inside page files
* keep them generic and reusable

---

## Components

Reusable UI blocks must live in:

```text
pages/components/
```

Examples:

* `hero.php`
* `archive-search.php`
* `archive-grid.php`
* `pagination.php`
* `author-card.php`
* `topic-card.php`

Rules:

* use components for repeated UI patterns
* prefer composition over duplication
* components should be focused and reusable

---

## Granularity Rules

Follow these rules when structuring code:

* prefer small reusable components
* avoid duplicated markup
* separate layout from content
* keep navbar and footer as global primitives
* keep logic out of markup-heavy files when possible
* place code according to responsibility, not convenience

---

## Recommended Structure

```text
theme/
  functions.php
  includes/
    assemble.php
    custom.php
    enqueue.php
    images.php
    init.php
    modify.php
    utils.php
  pages/
    frontpage.php
    authors.php
    temas.php
    status404.php
    partials/
      header.php
      nav.php
      footer.php
    components/
      hero.php
      archive-search.php
      archive-grid.php
      pagination.php
      author-card.php
      topic-card.php
  assets/
    css/
    js/
    img/
```

---

## Rules for New Features

When adding new functionality:

1. Do not alter the architecture unless explicitly required.
2. Place the code in the correct include file based on responsibility.
3. Use the `lff_` prefix for all custom functions.
4. Use `lff_assemble_template()` for page composition.
5. Place page markup in `pages/`.
6. Use `pages/components/` for reusable UI.
7. Avoid duplicated markup and scattered logic.
8. Keep `functions.php` as a loader only.
9. Prefer extending existing primitives instead of bypassing them.

---

## Implementation Guidance for Agents

When implementing a feature in this theme:

1. Identify whether the change belongs to:

   * global setup
   * enqueueing
   * behavior/hooks
   * utilities
   * page rendering
   * partials
   * components

2. Place code in the matching file or create a new file only if necessary and coherent with the architecture.

3. If a page is needed:

   * create or update the page file inside `pages/`
   * compose it through `lff_assemble_template()`

4. If UI is reusable:

   * extract it into `pages/components/`

5. If logic is reusable and not a callback:

   * place it in `includes/utils.php`

6. If the work touches WordPress hooks:

   * place it in `includes/custom.php`, `includes/init.php`, or `includes/modify.php` depending on intent

---

## Summary

This architecture enforces:

* modularity
* reusability
* separation of concerns
* maintainability
* predictable file ownership

Always adapt new features to this structure. Never bypass it with ad hoc template composition or misplaced logic.

````

La mejora clave frente al tuyo es que ahora sí tiene:

- **frontmatter YAML**
- **`name`**
- **`description`**
- **`when_to_use`**
- instrucciones más orientadas a que un agente lo pueda seguir sin ambigüedad

También te recomiendo cambiar el nombre del archivo a algo como:

```text
.opencode/skills/la-fonda-wordpress-theme-architecture/SKILL.md
````

Y si quieres, te lo puedo dejar en una versión todavía más **OpenCode-native**, con secciones tipo:

* `Do`
* `Do not`
* `Expected outputs`
* `File placement rules`

que suele funcionar mejor para agentes.
