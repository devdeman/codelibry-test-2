---
name: setup-design-system
description: Converts a Figma design into a rationalized design token system for this WordPress theme. Use this skill whenever a user provides a Figma URL or design screenshots and wants to set up or update the theme's visual foundation — colors, fonts, typography scale, buttons, forms, spacing, radii, shadows. Also trigger when the user says "set up design system", "extract tokens", "set up styles from Figma", "update design tokens", or asks to convert a client design into theme styles. This skill handles messy, inconsistent Figma files by rationalizing raw values into a clean, minimal token set.
---

# Setup Design System from Figma

## Why this skill exists

Client Figma files are almost never clean. Designers use 15 shades of grey when 3 would do, scatter font sizes across a 20-value spectrum, and mix spacing values inconsistently. The job here is to extract the *design intent* behind a messy Figma file and build a clean, logical design system from it — not to replicate every pixel value.

The theme's starter SCSS architecture (`_root.scss`, `_fonts.scss`, `_typography.scss`, layout primitives, component styles) is a **starting example**, not a fixed structure. You have full freedom to reshape it: rename tokens, add new ones, remove unused ones, restructure categories, add or remove button/form variants, change how layout primitives work — whatever produces the most logical, internally consistent design system for this specific project's design.

## What this skill produces

A complete design system materialized as SCSS source files:
- `src/scss/global/_fonts.scss` — @font-face declarations
- `src/scss/global/_root.scss` — all CSS custom properties (the token architecture you design)
- `src/scss/global/_base.scss` — base element styles
- `src/scss/global/_typography.scss` — heading/body type system
- `src/scss/parts/_button.scss` — button system (mixin + variants)
- `src/scss/parts/_form.scss` — form element styles
- `src/scss/layout/` — layout primitives, wired to spacing tokens

Plus: font files downloaded to `assets/fonts/` and the basestyle reference page synced.

## Prerequisites

- Figma MCP server must be connected
- User provides a Figma URL, node ID, or screenshot

---

## Workflow

### Step 1 — Fetch the design from Figma

Get as much visual context as possible:

1. If the user gave a Figma URL, parse out `fileKey` and `nodeId`
2. Call `get_design_context(fileKey, nodeId)` for structured data (colors, typography, spacing)
3. Call `get_screenshot(fileKey, nodeId)` for visual reference
4. If the design has a dedicated "Style Guide" or "Design System" page, fetch that too — it's the richest source of tokens
5. If the file is large or truncated, use `get_metadata` first to find key frames, then fetch them individually

**What to look for:** color palette, heading specimens, body text, buttons (primary + secondary), form inputs, card patterns, section spacing, border radii, shadows, font names and weights.

If the Figma file has published styles or variables, those are the most reliable source — prioritize them over values picked from individual frames.

### Step 2 — Audit and rationalize

Read `references/token-rationalization.md` for detailed guidance. The examples there are starting points — adapt the token structure to what the design actually needs.

**Colors** — Collect every unique color. Group by semantic role. Merge near-duplicates. The starter uses ~10 tokens (`--color-primary`, `--color-dark`, etc.) but your design might need more granularity (e.g., `--color-muted`, `--color-border`, `--color-surface`) or fewer. Name by role, not hue. Let the design dictate the palette structure.

**Typography** — Collect every font-size. Build a scale that covers the design — could be 7 steps, could be 12. Use `clamp()` for fluid sizing on larger heading sizes. Identify font families and weights actually used. If the design only uses 3 weights, define 3, not 4.

**Spacing** — Collect every recurring spacing value (padding, margins, gaps). Derive a scale that covers the design's rhythm. Typically 5–8 steps, but let the actual values drive the count.

**Layout** — Identify container widths, section padding patterns, grid structures.

**Radii** — Collect unique values, collapse to as many or few slots as the design uses.

**Effects** — Shadows, borders, transitions.

**Buttons** — Identify every distinct button style. Could be 1 variant, could be 4.

**Forms** — Input, textarea, select, checkbox, radio — whatever the design specifies.

### Step 3 — Present the plan and wait for approval

Before touching any files, show the user a clear summary table:

```
## Proposed Design System

### Colors
[Table with columns: Token | Value | Usage]
List every color token you propose — name them by semantic role.
Include any tokens you're adding or renaming vs. the starter set.

### Typography
[Table with columns: Token | Value]
List the full font-size scale, font families, weights, and line-heights.
The scale can have more or fewer steps than the starter's 9 — fit the design.

### Spacing
[Table with columns: Token | Value | Usage]
List the spacing scale derived from the design.

### Layout & Radius
[Table with columns: Token | Value]
Container widths, border radii, shadows, borders, transitions.

### Buttons
Describe each variant: bg, text color, border, radius, weight, text-transform.
Could be 1 variant or 5 — match the design.

### Forms
Input, select, textarea styling: border, padding, radius, focus state.

### Structural changes
- [Tokens added that don't exist in the starter]
- [Tokens removed or renamed from the starter]
- [Component styles restructured and why]

### Resolved inconsistencies
- [What you merged, dropped, or rationalized from the Figma and why]
```

**Wait for user confirmation before proceeding.** This is the most important checkpoint — the user may want to adjust colors, pick a different font weight mapping, or override a rationalization decision.

### Step 4 — Download and install fonts

If the design uses fonts other than the current ones:

1. Check `assets/fonts/` for existing files
2. For Google Fonts, download `.woff2` files for each needed weight (typically 400, 500, 600, 700)
3. For commercial fonts, tell the user to provide `.woff2` files and place them in `assets/fonts/`, then proceed with the SCSS updates assuming the files will be there
4. Only `.woff2` format, self-hosted — never link to CDNs in SCSS

### Step 5 — Update SCSS files

Apply changes in this order. Read `references/scss-update-guide.md` for file-specific patterns and examples — but treat those as a starting template, not a rigid spec.

1. **`_fonts.scss`** — Replace @font-face declarations for the new font(s)
2. **`_root.scss`** — Rebuild the token architecture to match your proposed plan. You can rename tokens, add new categories, remove unused ones, restructure sections. The existing file is an example structure — reshape it to be the most logical representation of this project's design system.
3. **`_base.scss`** — Update base element styles (body, links, selection, focus) to reference the new tokens. Restructure if the design calls for different base behavior.
4. **`_typography.scss`** — Update heading/body type system. Add or remove heading levels, change the mixin, adjust utility classes — whatever the design needs.
5. **`_button.scss`** — Rebuild the button system to match the design. Add variants (ghost, outline, link-style, sizes) or simplify to fewer. Restructure the mixin if needed.
6. **`_form.scss`** — Rebuild form element styles to match the design.
7. **Layout primitives** — Wire spacing tokens into layout files (`_flow.scss`, `_grid.scss`, `_cluster.scss`, `_repel.scss`, `_switcher.scss`, `_box.scss`, `_section.scss`, `_container.scss`). You can also modify how these primitives work if the design suggests a different approach.

### Step 6 — Sync basestyle and build

**Sync `basestyle.php` with the updated SCSS:**

1. **Read all relevant SCSS source files:**
   - `src/scss/global/_root.scss` — CSS custom properties (colors, sizes, weights, line-heights, containers, radii, transitions, borders, shadows)
   - `src/scss/global/_typography.scss` — heading tags and utility classes
   - `src/scss/global/_breakpoints.scss` — breakpoint mixins and values
   - `src/scss/parts/_button.scss` — button variants and CSS variables
   - `src/scss/parts/_form.scss` — input, textarea, select, label styles
   - `src/scss/layout/_container.scss` — container variants
   - `src/scss/layout/_grid.scss` — grid and data-columns variants
   - `src/scss/layout/_cluster.scss`
   - `src/scss/layout/_repel.scss`
   - `src/scss/layout/_switcher.scss`
   - `src/scss/layout/_flow.scss`
   - `src/scss/layout/_box.scss`
   - `src/scss/layout/_section.scss`
   - `src/scss/utilities/_display.scss`
   - `src/scss/utilities/_visually-hidden.scss`

2. **Diff against what `basestyle.php` currently documents:**
   - New CSS variables added to `_root.scss` → add swatches/rows
   - Removed or renamed variables → remove or update entries
   - New button variants → add live examples
   - New layout primitives or utility classes → add demo sections
   - Changed values (e.g. breakpoint px, radius values) → update the displayed values
   - Removed classes → remove their sections

3. **Update `basestyle.php` in place:**
   - Keep the existing page structure and style
   - Only change what has actually diverged from the SCSS source
   - Every value shown on the page must come from the SCSS files — no hardcoding values that differ from the source
   - All live examples must use the real CSS classes (no mock wrappers or inline re-implementations)
   - Do not remove sections that still exist in SCSS
   - Do not add sections for classes/variables that do not exist in SCSS
   - Keep the page using `.section` + `.container` + `.flow` + `.box` for its own layout
   - Values in tables and labels must match the SCSS source exactly

**Then build:**

4. Run `npm run build` to compile SCSS and verify no build errors
5. Report the result to the user

---

## Principles

These guide the design decisions, not restrict them:

- **Rationalize, don't replicate.** The design *intent* matters more than exact pixel values. If Figma has `#1a1a1a` in one frame and `#1b1b1b` in another, the intent is "dark text" — pick one. The goal is a coherent system, not a 1:1 Figma mirror.
- **Let the design dictate the structure.** The existing tokens, names, and categories are a starting template. If the design needs `--color-muted` and `--color-border` but doesn't need `--color-secondary`, make that change. If it uses 5 heading sizes not 6, define 5. The system should fit the design like a glove.
- **Every token should earn its place.** Don't add tokens "just in case." Each one should map to a real, recurring value in the design. But equally, don't artificially constrain the count — if the design genuinely uses 15 distinct, purposeful colors, define 15.
- **Fluid typography for large sizes.** Use `clamp()` with a `vw` middle value for heading sizes that need to scale between mobile and desktop. Smaller body/caption sizes can be static.
- **Self-hosted fonts.** `.woff2` in `assets/fonts/`, referenced via `url('../../assets/fonts/...')`. No CDN links in SCSS.
- **Respect the cascade.** `_base.scss` and `_typography.scss` set defaults via `var()`. Blocks and components inherit. A well-designed token system means less CSS in individual components.
- **Preserve the SCSS file organization.** Global tokens in `global/`, layout in `layout/`, components in `parts/`. You can freely modify content within files and rename tokens, but keep this directory structure — it's how the build pipeline and auto-loading work.
