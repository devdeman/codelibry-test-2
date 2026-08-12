# Token Rationalization Guide

How to convert raw Figma values into a clean design token system. The examples below use the starter theme's naming as illustration, but you should adapt names, categories, and slot counts to fit the actual design.

## Core philosophy

A design system is a vocabulary, not a cage. The right number of tokens is however many the design genuinely uses — no artificial ceiling, no padding with unused slots. Every token should map to a real, recurring value. If the design uses 6 colors, define 6. If it uses 20 distinct, purposeful colors across a complex UI, define 20.

That said, client Figma files are messy. The skill here is distinguishing **intentional variety** from **accidental inconsistency**. Three slightly different greys in a card component are probably one grey used imprecisely. Three distinctly different greys used for text, borders, and backgrounds are three purposeful tokens.

---

## Colors

### Collection
Extract every unique color value from the Figma design — fill colors, text colors, borders, backgrounds, shadows.

### Semantic grouping
Group colors by their role in the UI. Common roles (adapt names to fit the design):

| Role | Example tokens | Purpose |
|------|---------------|---------|
| Brand / accent | `--color-primary`, `--color-accent` | CTAs, links, active states |
| Secondary accent | `--color-secondary` | Supporting highlights, badges |
| Text | `--color-text`, `--color-text-muted` | Body copy, secondary text |
| Backgrounds | `--color-bg`, `--color-surface` | Page background, card surfaces |
| Borders | `--color-border` | Dividers, input borders |
| Neutral extremes | `--color-black`, `--color-white` | When pure black/white is needed |
| Feedback | `--color-success`, `--color-warning`, `--color-error` | Status indicators |

This table is a starting point. If the design has a rich palette with distinct hover states, gradient stops, or overlay colors that recur, give them tokens. If the design is minimal and uses only 5 colors, define 5.

### Merging near-duplicates
If two colors are perceptually identical (roughly ΔE < 3 — you can't tell them apart at a glance), merge to one. Pick the more frequently used value.

Common patterns:
- `#1a1a1a` and `#1b1b1b` → one text color
- `#f5f5f5` and `#f7f7f7` → one background color
- Brand color at 90% and 100% opacity → pick the solid version

### Naming
Name by role, not by hue: `--color-primary` not `--color-blue`. If the design has multiple brand colors, consider `--color-brand-1`, `--color-brand-2` or more descriptive names like `--color-coral`, `--color-navy` if that's how the team talks about them.

---

## Typography

### Font size scale
Collect every font size from the design and organize into a scale. The starter uses 9 slots (h1–h6 + md/sm/xs), but your design might need:
- Fewer: a minimal design might use only 5–6 distinct sizes
- More: a complex UI might need `--size-xl`, `--size-2xs`, `--size-display`, etc.

Let the design dictate the count. For reference:

| Size category | Typical range | Notes |
|--------------|---------------|-------|
| Display / hero | 48–96px | `clamp()` fluid, used sparingly |
| Primary headings | 32–56px | `clamp()` fluid |
| Secondary headings | 24–36px | `clamp()` fluid or static |
| Tertiary headings | 18–28px | Usually static |
| Body text | 14–18px | Static |
| Small / caption | 11–14px | Static |

### Building clamp() values
For sizes that need fluid scaling between mobile and desktop:

Pattern: `clamp(min, preferred, max)`
- **min**: the mobile size in `rem`
- **max**: the desktop size in `rem`
- **preferred**: calculate `(max_px - min_px) / (1440 - 390) * 100` vw (assuming 1440px desktop, 390px mobile), round to one decimal

Example: 40px mobile → 54px desktop → `clamp(2.5rem, 1.3vw + 2rem, 3.375rem)`

Use fluid sizing for large headings that visually need to scale. Smaller sizes (body, captions) are usually fine as static `rem` values.

### Font families
Identify distinct font roles:
- **Headings** — often a display, serif, or branded typeface
- **Body** — often a clean sans-serif

If the design uses one font for everything, define one. If it uses two, define two. If it genuinely uses three (e.g., headings, body, and monospace for code), define three. Don't force-consolidate if the third font serves a clear purpose.

### Font weights
Define tokens for the weights actually used. If the design only uses Regular (400) and Bold (700), define two weight tokens, not four. Common weights:

| Weight | Typical numeric value |
|--------|----------------------|
| Light | 300 |
| Regular | 400 |
| Medium | 500 |
| Semi-bold | 600 |
| Bold | 700 |
| Extra-bold / Black | 800–900 |

Merge weights that are used interchangeably — if the design uses 600 and 700 in what appears to be the same "bold" role, pick one.

### Line heights
Define tokens for the distinct line-height values actually used. Common patterns:

| Usage | Typical values |
|-------|---------------|
| Tight / headings | 1–1.15 |
| Default / comfortable | 1.2–1.35 |
| Relaxed / body text | 1.4–1.6 |
| Loose / long-form | 1.6–1.8 |

---

## Spacing

### Extraction
Measure every recurring spacing value in the Figma design:
- Padding inside cards, sections, buttons, inputs
- Gaps between grid items, list items, flex children
- Margins between sections, between heading and body text
- Icon-to-text distances

### Building the scale
Most designs cluster around a limited set of spacing values. Collapse them into a proportional scale — typically 5–8 steps, but could be more for complex UIs.

Example scale (adapt to your design):

| Scale step | Typical range | Usage pattern |
|------------|---------------|---------------|
| Tiny | 2–6px | Icon padding, inline spacing |
| Small | 6–12px | Compact lists, label-to-input gaps |
| Medium | 14–20px | Default gaps, paragraph spacing |
| Large | 20–32px | Section inner spacing, content groups |
| XL | 32–48px | Card padding, large gaps |
| 2XL | 48–64px | Section vertical padding |
| 3XL | 64–96px | Hero spacing, major dividers |

### Rationalization
- If the design uses 8px, 9px, and 10px in different places, those are one intent — pick a round value
- If two adjacent scale steps would be less than 4px apart, merge them
- The scale should feel proportional: roughly 1.5–2× between each step

### How spacing tokens integrate with layout primitives
Spacing tokens serve as the vocabulary for inline CSS variable overrides on layout primitives:

```html
<div class="grid" style="--gap: var(--space-lg)" data-columns="3">
<div class="flow" style="--flow-space: var(--space-xl)">
```

And as default values inside layout SCSS:
```scss
.section { padding: var(--space-2xl) 0; }
@mixin box { padding: var(--space-xl); }
```

---

## Layout

### Container widths
Look at the Figma frame widths and content areas. The design might use 2, 3, or 4 distinct container widths. Common patterns:
- Narrow content (text pages) — 800–1000px
- Default content — 1100–1280px
- Wide (header, footer, hero) — 1300–1440px
- Full-bleed — 100%, no max-width

Define as many container width tokens as the design needs.

---

## Border Radius

Collect every unique radius value and group by usage. The design might use:
- One radius everywhere (simple)
- 2–3 distinct radii (common)
- 5+ radii (complex component library)

Define tokens that match. If the design uses `4px` for inputs and `8px` for cards, that's two tokens, not five with three unused.

Common patterns to look for:
- Small: tags, badges, inputs
- Medium: buttons, cards
- Large: modals, sections
- Full / pill: rounded buttons, avatars

---

## Effects

Look for recurring visual effects:
- **Shadows**: Could be one shadow or a shadow scale (sm/md/lg). Define what the design uses.
- **Borders**: Default border style, might vary by context (input borders vs. dividers)
- **Transitions**: Usually one base transition unless the design has distinct animation styles
- **Overlays**: Background overlays for modals, dropdowns

---

## Buttons

Extract every distinct button style from the design. For each:

| Property | What to look for |
|----------|-----------------|
| Background | Fill color |
| Text color | Label color |
| Padding | Vertical and horizontal |
| Border radius | Should reference a radius token |
| Font weight | Should reference a weight token |
| Font size | Could vary by button size |
| Text transform | uppercase, none, capitalize |
| Border | Style, color, width |
| Hover state | What changes on hover |
| Disabled state | Opacity, color changes |

Define as many button variants as the design has: primary, secondary, ghost, outline, link-style, destructive, sizes (sm/md/lg). Don't invent variants the design doesn't use, but don't limit to 2 if the design clearly has more.

---

## Forms

Extract styling from every form element type the design shows:
- Text inputs, textareas
- Selects / dropdowns
- Checkboxes, radios
- Toggles / switches
- Labels, help text, error messages

For each, note: border, padding, radius, background, placeholder styling, focus state, error state, disabled state.
