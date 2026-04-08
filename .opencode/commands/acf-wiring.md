---
description: Wire a raw HTML source into a WordPress PHP template using the local ACF page-builder architecture. Receives: $1 raw HTML path, $2 PHP template path or template name, $3 ACF group JSON path, and optional $4 extra prompt path.
agent: Sdd-Orchestrator
---

Wire the raw HTML found at `$1` into the WordPress PHP template identified by `$2`, using the ACF field group JSON at `$3` as the data contract reference.

Before doing implementation work, load and follow the local skill `wp-acf-page-builder` so the result stays aligned with the real page-builder architecture used in this repo.

Inputs:
- `$1`: raw HTML file path
- `$2`: target PHP template path or template name
- `$3`: related ACF field group JSON path
- `$4`: optional extra prompt or guidance file path

Use an SDD flow by phases instead of implementing everything at once:
1. Inspect the HTML, template target, and ACF group structure.
2. Propose how the HTML should map into the local builder/template architecture.
3. Define the ACF wiring and template/component responsibilities.
4. Apply the implementation in the correct WordPress/theme layer.
5. Verify the final wiring is consistent with the local architecture and the provided ACF schema.

If `$4` is provided, treat it as additional instructions that refine scope or constraints.
