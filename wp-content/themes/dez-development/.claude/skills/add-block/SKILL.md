---
name: add-block
description: Creates ACF Flexible Content blocks from an image or a Figma frame/node URL for this theme. Use when the user asks to create a new section/block, convert a design to code, or replicate a Figma frame while preserving the project's PHP/ACF/SCSS conventions.
---

# Add Block

## When To Use

Use this skill when the task is to create a new theme block from:
- a screenshot/image/mockup, or
- a Figma URL (`figma.com/design/...` with `node-id=...`).

This theme uses ACF Flexible Content blocks, not Gutenberg Block API.

## Required Output Standard

For a new block slug `my-block`, produce this exact structure unless the user asks otherwise:

1. `inc/acf/blocks/my-block.php`
2. add layout in `inc/acf/templates/page-blocks.php`
3. optionally add the same layout to `inc/acf/post-types/reusable-blocks.php` (if reusable is requested)
4. `template-parts/blocks/my-block.php`
5. `src/scss/blocks/_my-block.scss`
6. import in `src/scss/main.scss`
7. optional JS: `src/js/my-block.js` and wire it in `src/main.js`

## Project Conventions (Must Preserve)

- Layout name must match template filename: `my-block` -> `template-parts/blocks/my-block.php`.
- ACF fields function naming: `codelibry_acf_fields_my_block()`.
- ACF field names: kebab-case with block prefix (example: `my-block-title`).
- Never add ACF `key` manually (ACFComposer generates it).
- Template field reads must use:
  - `get_array_value($args, 'field-name', get('field-name'))`
- Sanitize output:
  - plain text: `esc_html`
  - rich text: `wp_kses_post`
  - URLs/attrs: `esc_url`, `esc_attr` as needed
- Use project tokens from `src/scss/global/_root.scss` via `var(--...)`.
- Reuse existing layout primitives (`container`, `section`, `grid`, `flow`, `switcher`, etc.) before adding custom CSS.
- Keep import layering in `src/scss/main.scss` intact.

## Input Modes

### Mode A: From Image

1. Infer section anatomy (container, columns, spacing, CTA/media).
2. Map design to existing tokens and primitives.
3. Generate the block files and registrations using the output standard.

### Mode B: From Figma URL

1. Parse `fileKey` and `nodeId` from URL:
   - `figma.com/design/:fileKey/:name?node-id=:nodeId`
   - `figma.com/design/:fileKey/branch/:branchKey/:name` -> use `branchKey` as file key
   - `figma.com/make/:makeFileKey/:name` -> use `makeFileKey` as file key
   - convert node id dashes to colons (`1-2` -> `1:2`) before MCP call.
2. If Figma MCP is available, prefer design context fetch (`get_design_context`) using `fileKey + nodeId`.
3. Convert the design into theme primitives/tokens (do not mirror absolute-position internals blindly).
4. Generate block files and registrations using the same output standard.

If the URL is FigJam (`figma.com/board/...`), treat it as reference-only and ask for a concrete target frame or screenshot before coding.
If Figma context cannot be fetched, ask for screenshot/specs and continue in Image mode.

## Execution Workflow

Copy and follow this checklist:

```text
Task Progress:
- [ ] 1) Confirm block slug and whether reusable registration is needed
- [ ] 2) Build ACF fields file in inc/acf/blocks/
- [ ] 3) Register layout in page-blocks.php (+ reusable-blocks.php if required)
- [ ] 4) Create template in template-parts/blocks/
- [ ] 5) Create SCSS partial and import it in src/scss/main.scss
- [ ] 6) Add JS module/wiring only if behavior is required
- [ ] 7) Run quality gates and list verification commands
```

## Quality Gates (Before Finish)

Ensure all items are true:

- Naming is consistent across slug/function/layout/template/SCSS import.
- `page-blocks.php` contains the new layout using the correct `sub_fields` function.
- Template uses `get_array_value(..., get(...))` fallback pattern.
- Output escaping is correct for each field type.
- Styles rely on `var(--...)` tokens; avoid introducing raw hex if a token exists.
- `src/scss/main.scss` includes the new block import in the blocks section.
- If JS was added, `src/main.js` imports and executes it.
- Suggest verification command(s): `npm run build` (and `npm start` for watch).

## Default Decisions

When the user does not specify:

- block slug: derive from section intent in kebab-case
- reusable: default `no`
- JS module: default `no` unless interactivity is obvious
- typography/colors/spacing: use closest existing tokens and primitives first

## What Not To Do

- Do not implement with Gutenberg block registration for standard theme blocks.
- Do not break existing file organization or import order.
- Do not duplicate primitives/components already present in `layout/` or `parts/`.
- Do not add unrelated refactors while scaffolding the block.

## Additional Resources

- Detailed templates and checklists: [reference.md](reference.md)
