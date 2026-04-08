---
name: wp-frontend-js
description: >
  Frontend JavaScript guidance for La Fonda's static HTML site using browser-native ES modules,
  Bootstrap 5, Swiper, and Sass. Trigger: When editing `js/`, wiring behavior to static pages,
  adding UI interactions, or touching shared frontend markup/styles in this repo.
license: Apache-2.0
metadata:
  author: gentleman-programming
  version: "1.0"
---

## When to Use

- Add or update browser-side behavior in `js/main.js` or `js/components/`.

## Critical Patterns

- Keep JavaScript as browser-native ES modules; do not introduce bundlers, frameworks, or new dependencies.
- Put reusable behavior in `js/components/`; keep `js/main.js` as the small app/bootstrap entry point.
- Preserve existing hooks like `.js-*`, `data-js-*`, and IDs; prefer reusing them over inventing new selectors.
- When shared markup changes, verify all static pages stay consistent because header/footer sections are duplicated manually.
- Edit styles in `scss/`, never in `css/main.css`; rebuild CSS after Sass changes with `npm run build:css`.
- Match the current style of direct module imports and simple class-based initialization.
- Always program in POO if it's a new feature, for example, if we got a slider we need to create a new instance of this with a certain ID rule (like selecting '#js-slider-1') this should work for all selectors like that.
- every feature should come from `js/components`in where the classes should store (like slider, live searcher, etc.)

## Code Examples

```js
// js/components/example-toggle.js
export class ExampleToggle {
  constructor(selector = "[data-js-example-toggle]") {
    this.selector = selector
  }

  init() {
    document.querySelectorAll(this.selector).forEach((button) => {
      button.addEventListener("click", () => {
        button.classList.toggle("is-active")
      })
    })
  }
}
```

```js
// js/main.js
import { SliderFactory } from "./components/slider.js"
import { ExampleToggle } from "./components/example-toggle.js"

document.addEventListener("DOMContentLoaded", () => {
  new SliderFactory().init()
  new ExampleToggle().init()
})
```

```scss
// scss/components/_example-toggle.scss
.example-toggle.is-active {
  box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.08);
}
```

## Commands

```bash
npm run build:css
npm run watch:css
```

## Resources

- `AGENTS.md` - repo workflow, DOM-hook, and static-page constraints.
- `js/main.js` - entry-point initialization pattern.
- `js/components/slider.js` - current component/module structure and Swiper import pattern.
- `scss/main.scss` - Sass entry point for component styling.
- Static pages like `index.html`, `single-filosofo.html`, `single-tema.html`, and `single.html` must stay aligned when shared markup changes.
