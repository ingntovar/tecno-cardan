---
description: Create a reusable visual hero component for the Wordpress theme following the existing architecture and ACF conventions
agent: Sdd-Orchestrator
---

# Goal

Create a new **Hero component** for the Wordpress theme.

# Context

This component belongs to the current theme architecture and must integrate cleanly with the existing Wordpress structure, styling conventions, and ACF field wiring.

Follow the local architecture and reuse existing project conventions. Pay special attention to:

- `wp-theme-architecture`
- Existing ACF group field patterns inside `includes/acf/json-sync`
- Existing reusable CTA patterns if present in the theme

# Feature Summary

We need to build a **visual hero** component with:

- Title
- Copy
- CTA
- Background image

The visual mockup reference is located at:

`themes/tecno-cardan/mockups/visual_hero.png`

# Functional Requirements

## Content fields

The Hero must have four main fields:

1. **Title**
2. **Copy**
3. **CTA**
4. **Background image**

## CTA requirements

- The CTA must be **reusable**
- Use the existing ACF group field patterns as reference
- Inspect `includes/acf/json-sync` and follow the same architecture for reusable field groups
- Do not invent a one-off CTA structure if a reusable approach already exists or can be aligned with current conventions

## Layout requirements

- Use **Bootstrap** for the layout structure
- The content must be aligned to the **left side**
- The **Title** must appear large on the left
- The **Copy** must appear below the title
- The **CTA** must appear below the copy
- The **background image** must be rendered as a **background image**, not as an inline `img` element

# Visual Requirements

## General composition

- Title, Copy, and CTA must all be placed on the **left side**
- The Hero must include a **dark overlay** above the background image to ensure contrast and readability
- The content should remain readable over the image at all times

## Overlay specification (VERY IMPORTANT)

- The overlay must be based on a **dark blue tone**, using the primary palette (`#0D1B2A`)
- The overlay must use a **left-to-right gradient**
- Behavior of the gradient:
  - On the **left side (0% → ~50%)**:
    - The overlay must be **highly opaque**
    - This ensures strong readability for Title, Copy, and CTA
  - From **midpoint (~50%) to right (100%)**:
    - The overlay must progressively **fade out**
    - The background image should become increasingly visible
    - By the far right, the image should be **clearly visible with minimal overlay**

- This must be implemented using a **linear-gradient**, not multiple layers or hacks
- The gradient must feel smooth and natural, avoiding hard stops

## Typography and visibility

- **Title**
  - white color
  - large visual prominence
  - text shadow / shading for contrast

- **Copy**
  - white color
  - smaller than title
  - text shadow / shading for contrast

## CTA styling

- CTA background: **gold**
- CTA text: **blue**
- Ensure the CTA styling is reusable and not hardcoded only for this one instance

# Color System Requirements

Use these colors as the main design tokens of the component and update the SCSS so they become **reusable variables**.

## Primary blue palette

- `#0D1B2A` → main dark petroleum blue
- `#13293D` → secondary section blue
- `#1B3A57` → medium blue for hover/highlights

## Gold accent palette

- `#C89B3C` → main elegant gold
- `#A67C2E` → darker gold for borders/shadows

## Implementation requirement

Refactor the SCSS so these colors are stored in reusable variables/tokens and not repeated as raw hex values throughout the implementation.

# Technical Requirements

- Follow the existing Wordpress theme architecture exactly
- Reuse project patterns and conventions where possible
- Use **Bootstrap** for layout/grid/alignment
- Keep the component modular and reusable
- Wire ACF fields properly and defensively
- Respect naming conventions already used in the theme
- Keep the styling maintainable and reusable
- Do not break existing layout or styling contracts in the theme

# Constraints

- Do not invent a new architecture
- Do not hardcode content directly in templates
- Do not use inline styles unless the existing architecture explicitly requires a safe dynamic background image pattern
- Do not create an isolated CTA implementation if a reusable CTA structure is expected
- Do not modify unrelated components
- Do not change the overall visual language of the site outside this feature’s scope

# Expected Process

Follow the SSD methodology.

## Phase 1: Explore

Before implementing:

- Inspect the current theme architecture
- Inspect `includes/acf/json-sync`
- Identify how reusable group fields are currently defined
- Identify whether a reusable CTA field structure already exists
- Review the visual mockup at `themes/tecno-cardan/mockups/visual_hero.png`
- Inspect the current SCSS organization and determine the right place for reusable color variables
- Identify the best template/component location for this Hero in the existing architecture

## Phase 2: Proposal

Before applying changes, provide an implementation proposal.

The proposal must include:

- Which files will be created or updated
- Where the ACF fields will live
- How the reusable CTA structure will be modeled
- How the background image will be rendered
- How the Bootstrap layout will be structured
- How the overlay (gradient behavior included) will be implemented
- Where the SCSS variables will be added
- Any assumptions or risks

## Phase 3: Implementation

Only after approval, implement the feature.

# Output Expectations

Your response should:

- Be grounded in the existing codebase
- Reuse architecture instead of reinventing it
- Clearly explain the implementation path
- Call out any ambiguity or risks explicitly
- Prefer maintainability and consistency

# Additional Notes

Pay special attention to:

- proper ACF wiring
- reusable CTA structure
- Bootstrap-based layout
- background image handling
- gradient overlay implementation
- reusable SCSS color variables
- left-aligned composition matching the mockup
