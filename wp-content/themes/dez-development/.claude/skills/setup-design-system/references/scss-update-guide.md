# SCSS Update Guide

File-specific patterns for applying the design system. The examples below show the starter theme's structure — you can and should reshape token names, categories, and component styles to match what your design system plan calls for.

## Ground rule

The SCSS directory structure (`global/`, `layout/`, `parts/`, `mixins/`) is load-order dependent and should be preserved. But everything *inside* those files — token names, values, categories, selectors, mixin signatures — is yours to redesign.

---

## `src/scss/global/_fonts.scss`

One `@font-face` declaration per weight. Pattern:

```scss
@font-face {
  font-family: 'FontName';
  src: url('../../assets/fonts/FontName-Weight.woff2') format('woff2');
  font-weight: 400;
  font-display: swap;
}
```

- Path is always `../../assets/fonts/` (relative to `dist/css/main.min.css`)
- Only `.woff2` format
- Only declare weights that have actual files in `assets/fonts/`
- Order: lightest weight first

---

## `src/scss/global/_root.scss`

This is the heart of the design system — all CSS custom properties live here. Organize into logical sections with comments. The starter structure looks like this, but reshape as needed:

```scss
:root {
  /* COLORS */
  // ... all color tokens

  /* FONT SIZES */
  // ... type scale tokens (could be named --size-*, --text-*, --font-size-*, etc.)

  /* FONT FAMILIES */
  // ... font family tokens

  /* FONT WEIGHTS */
  // ... weight tokens

  /* LINE HEIGHTS */
  // ... line-height tokens

  /* SPACING */
  // ... spacing scale tokens

  /* CONTAINERS */
  // ... max-width tokens

  /* BORDER RADIUS */
  // ... radius tokens

  /* EFFECTS */
  // ... shadows, borders, transitions
}
```

**You can:**
- Rename any token (e.g., `--color-dark` → `--color-text`, `--size-h1` → `--text-display`)
- Add new categories (e.g., `/* Z-INDEX */`, `/* OPACITY */`)
- Remove categories or tokens that the design doesn't need
- Reorganize the section order
- Add sub-categories (e.g., split colors into `/* BRAND COLORS */` and `/* NEUTRAL COLORS */`)

**Keep in mind:**
- Every rename means updating references across all SCSS files that use the old name
- Clear, descriptive comments help future developers understand the system
- Group related tokens together for scannability

---

## `src/scss/global/_base.scss`

Base element styles — the defaults everything inherits from. Update to reference your new token names:

```scss
body {
  background: var(--your-bg-token);
  color: var(--your-text-token);
  font-size: var(--your-body-size-token);
  font-family: var(--your-body-font-token);
  font-weight: var(--your-regular-weight-token);
  line-height: var(--your-body-leading-token);
  // ...
}
```

You can also restructure base styles — add/remove default styles for elements like `img`, `hr`, `blockquote`, `code`, etc. based on what the design uses.

---

## `src/scss/global/_typography.scss`

The heading/body type system. The starter uses a `@mixin heading` applied to `h1`–`h6`:

```scss
@mixin heading {
  line-height: var(--leading-flat);
  font-family: var(--font-primary);
  font-weight: var(--font-bold);
}

h1, .h1 { font-size: var(--size-h1); }
// ...
```

You can restructure this completely:
- Different headings could have different weights or line-heights
- The design might not need utility classes (`.h1`, `.h2`)
- The design might need additional type styles (`.subtitle`, `.overline`, `.caption`)
- Letter-spacing might vary by heading level

---

## `src/scss/parts/_button.scss`

The starter uses a single `@mixin button` with CSS variable overrides. Adapt to match the design's button system:

**Simple design (1–2 variants):**
```scss
@mixin button { /* base styles */ }
.button { @include button; }
.button--secondary { /* overrides */ }
```

**Complex design (multiple variants + sizes):**
```scss
@mixin button-base { /* shared layout, typography, transition */ }

.button { @include button-base; /* primary styles */ }
.button--secondary { @include button-base; /* secondary styles */ }
.button--ghost { @include button-base; /* ghost styles */ }
.button--outline { @include button-base; /* outline styles */ }
.button--sm { /* size overrides */ }
.button--lg { /* size overrides */ }
```

Properties to set for each variant: background, color, border, padding, radius, font-weight, text-transform, hover state, disabled state, focus ring.

---

## `src/scss/parts/_form.scss`

The starter uses `@mixin input` applied to all text-like inputs. Adapt to match the design:

```scss
@mixin input {
  width: 100%;
  padding: var(--space-sm) var(--space-md);  // ← use spacing tokens
  border-radius: var(--radius-sm);
  border: 1px solid var(--color-border);
  // ... font, background, placeholder, focus styles
}
```

If the design has distinct styles for different form elements (e.g., search inputs look different from text inputs, or selects have custom styling), structure accordingly.

---

## Layout files

### Wiring spacing tokens into primitives

Once your spacing tokens exist in `_root.scss`, update layout primitives to reference them instead of hardcoded values:

**`_flow.scss`** — vertical spacing between children:
```scss
.flow > * + * {
  margin-top: var(--flow-space, var(--space-md));
}
```

**`_grid.scss`**, **`_cluster.scss`**, **`_repel.scss`**, **`_switcher.scss`** — default gap:
```scss
gap: var(--gap, var(--space-md));
```

**`_box.scss`** — card padding:
```scss
@mixin box {
  padding: var(--space-xl);
  border-radius: var(--radius-md);
  background-color: var(--color-white);
}
```

**`_section.scss`** — section padding:
```scss
.section { padding: var(--space-2xl) 0; }
```

**`_container.scss`** — mobile gutter:
```scss
@mixin container {
  margin-inline: auto;
  padding-left: var(--space-md);
  padding-right: var(--space-md);
  max-width: var(--container-md);
}
```

### Modifying primitives

If the design suggests different layout patterns, you can modify how primitives work:
- Change the `.grid` responsive breakpoints or `data-columns` variants
- Add new `data-columns` options (e.g., `data-columns="5"`)
- Modify the `.switcher` breakpoint calculation
- Add new layout primitives if the design calls for patterns not covered
- Remove primitives the design doesn't use

---

## After updating: cross-reference check

When you rename tokens, search the entire `src/scss/` directory for the old name and update all references. Key files that often reference tokens:
- `src/scss/parts/*.scss` — component styles
- `src/scss/blocks/*.scss` — ACF block styles
- `src/scss/pages/**/*.scss` — page-specific styles
- `src/scss/layout/*.scss` — layout primitives

Use find-and-replace across the codebase to ensure no broken `var()` references remain.
