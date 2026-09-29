---
description: Integrate structured HTML input as an ACF page-builder component through a dry-run approval workflow.
agent: sdd-orchestrator
---

Load and follow `.opencode/prompts/html-to-acf-component.prompt.md` as the authoritative integration prompt.

The user input is `$ARGUMENTS` and must be a structured object containing `html`, `component_name`, `component_slug`, `target_page`, and optional `visual_reference`.

Pass the complete payload to the reusable prompt unchanged. Do not reinterpret it as positional arguments or require a pre-existing ACF JSON file.

The reusable prompt's missing-target stop, dry-run, explicit approval gate, ACF Local JSON generation, validation, and no-build rules are mandatory.
