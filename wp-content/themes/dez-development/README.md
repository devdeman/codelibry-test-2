# Codelibry Mini Theme

A lean, component-driven WordPress theme built on ACF Flexible Content, Webpack 5, and a set of composable CSS layout primitives.

---

## Requirements

| Tool | Version |
|------|---------|
| WordPress | 6.0+ |
| PHP | 8.0+ |
| Node.js | 18+ |
| Composer | 2+ |
| ACF Pro | any recent |

---

## Setup

### 1. Install PHP dependencies

```bash
composer install
```

This installs [`flyntwp/acf-field-group-composer`](https://github.com/flyntwp/acf-field-group-composer), which handles ACF field key generation.

### 2. Install Node dependencies

```bash
npm install
```

### 3. Configure environment

Copy `.env.example` to `.env` and fill in your FTP credentials:

```bash
cp .env.example .env
```

```env
STAGING_FTP_HOST=
STAGING_FTP_USER=
STAGING_FTP_PASSWORD=

LIVE_FTP_HOST=
LIVE_FTP_USER=
LIVE_FTP_PASSWORD=
```

The `.env` file is only needed for deployment — development works without it.

### 4. Activate the theme

Activate **Codelibry Mini Theme** in **WordPress Admin → Appearance → Themes**.

### 5. Flush rewrite rules

Go to **Settings → Permalinks** and click **Save Changes**. This is required for the `/BaseStyle/` route to work.

---

## Development

```bash
# Start Webpack in watch mode (compiles on every file save)
npm start

# One-time production build (minified, no source maps)
npm run build
```

Compiled output lands in `dist/`:
- `dist/main.min.js`
- `dist/css/main.min.css`

> Always run `npm run build` before deploying.

---

## Deployment

```bash
# Deploy to staging
npm run deploy:staging

# Deploy to live
npm run deploy:live

# Package theme as codelibry.zip (one level up)
npm run zip
```

The deploy script uploads the `dist/` folder via FTP using credentials from `.env`.

---

## Project Structure

```
codelibry-mini-theme/
│
├── assets/                     Static files (images, icons, fonts)
│   ├── icons/
│   └── images/
│
├── dist/                       Compiled output (do not edit manually)
│   ├── main.min.js
│   └── css/main.min.css
│
├── inc/                        PHP logic — all auto-loaded by glob()
│   ├── acf/
│   │   ├── blocks/             Field definitions (pure functions, no registration)
│   │   ├── templates/          Field group registrations per page template
│   │   ├── post-types/         Field group registrations per CPT
│   │   └── options/            ACF Options page fields (header, footer, 404)
│   ├── helpers/                Global PHP helper functions
│   ├── post-types/             CPT registrations
│   ├── taxonomies/             Custom taxonomy registrations
│   ├── shortcodes/             Shortcode definitions
│   ├── ajax/                   AJAX handlers
│   └── theme-hooks/            wp hooks (enqueue, menus, theme support, etc.)
│
├── src/
│   ├── js/                     JavaScript modules (one file per block/feature)
│   │   └── main.js             Entry point — imports and calls all modules
│   └── scss/
│       ├── main.scss           Entry point — imports everything
│       ├── global/             Reset, fonts, base styles, typography, root variables
│       ├── layout/             CSS layout primitives (container, grid, flow, etc.)
│       ├── mixins/             SCSS mixins (reset-button, image-cover, etc.)
│       ├── parts/              Site parts (header, footer, button, form, etc.)
│       ├── blocks/             Per-block styles
│       └── utilities/          Display helpers, visually-hidden
│
├── template-parts/
│   ├── blocks/                 Block templates (loaded by page.php)
│   ├── header/
│   ├── footer/
│   └── parts/                  Shared partials (section-header, etc.)
│
├── page-templates/             Custom WordPress page templates
│
├── functions.php               Bootstraps all inc/ loaders
├── page.php                    Default page template — renders flexible content blocks
├── basestyle.php               Live CSS reference at /BaseStyle/
└── basestyle-route.php         Registers the /BaseStyle/ rewrite rule
```

---

## PHP Loading Order

`functions.php` loads each `inc/*.php` loader in this order:

```
inc/acf.php → inc/helpers.php → inc/shortcodes.php → inc/ajax.php
→ inc/post-types.php → inc/taxonomies.php → inc/theme-hooks.php
```

Each loader uses `glob()` to auto-require every `.php` file in its subdirectory.
**Drop a new file in the right folder — it gets picked up automatically. No manual registration needed.**

---

## How Pages Work

Pages use **ACF Flexible Content**. Each layout in the `page-blocks` field maps 1-to-1 to a template file:

```
ACF layout name: "image-text"
         ↓
template-parts/blocks/image-text.php
```

`page.php` loops the flexible content rows and calls `get_template_part()` with the block data passed as `$args`.

---

## Adding a Block

### 1. ACF fields

Create `inc/acf/blocks/my-block.php`:

```php
function codelibry_acf_fields_my_block(): array {
    return [
        [
            'label' => 'Title',
            'name'  => 'my-block-title',
            'type'  => 'text',
        ],
    ];
}
```

Never add a `key` — ACFComposer generates it automatically.

### 2. Register the layout

Add to the `'layouts'` array in `inc/acf/templates/page-blocks.php`:

```php
[
    'name'       => 'my-block',
    'label'      => 'My Block',
    'display'    => 'block',
    'sub_fields' => codelibry_acf_fields_my_block(),
],
```

Add the same entry to `inc/acf/post-types/reusable-blocks.php` if the block should be reusable.

### 3. SCSS

Create `src/scss/blocks/_my-block.scss` and import it in `src/scss/main.scss`:

```scss
/* Blocks */
@import "blocks/my-block";
```

Use CSS variables and layout mixins before writing any custom CSS — see the [CSS Architecture](#css-architecture) section.

### 4. JavaScript (optional)

Create `src/js/my-block.js`:

```js
export default function MyBlock() {
  // ...
}
```

Import and call it in `src/js/main.js`:

```js
import MyBlock from './my-block';
document.addEventListener('DOMContentLoaded', () => {
  MyBlock();
});
```

### 5. Template

Create `template-parts/blocks/my-block.php`:

```php
<?php
$title = get_array_value($args, 'my-block-title', get('my-block-title'));
?>
<section class="my-block section">
  <div class="container">
    <?php if ($title): ?>
      <h2><?php echo esc_html($title); ?></h2>
    <?php endif; ?>
  </div>
</section>
```

Always read fields with `get_array_value($args, 'field', get('field'))` — this works both when `$args` is populated (from `page.php`) and when called standalone.

---

## Adding a Custom Post Type

Create `inc/post-types/my-cpt.php`. It gets auto-loaded. For ACF fields, create `inc/acf/post-types/my-cpt.php`.

---

## Adding a Page Template

1. Create `page-templates/my-template.php` with a template header:

```php
<?php /* Template Name: My Template */ ?>
```

2. Optionally create `inc/acf/templates/my-template.php` for template-specific ACF fields — it's auto-loaded.

---

## CSS Architecture

### Variables

All design tokens live in `src/scss/global/_root.scss` as CSS custom properties:

| Category | Examples |
|----------|---------|
| Colors | `--color-primary`, `--color-dark`, `--color-light` |
| Font sizes | `--size-h1` … `--size-xs` |
| Font weights | `--font-bold`, `--font-regular` |
| Line heights | `--leading-flat`, `--leading-relaxed` |
| Containers | `--container-sm` (980px), `--container-md` (1200px), `--container-lg` (1300px) |
| Radii | `--radius-xs` … `--radius-xl` |
| Effects | `--shadow-base`, `--stroke-base`, `--transition-base` |

### Layout Primitives

Composable, single-responsibility classes. Combine them freely in HTML — no custom CSS needed for structure.

| Class | What it does |
|-------|-------------|
| `.container` | Centers content, max-width `--container-md`, 1rem side padding |
| `.container-sm` | Same but max-width `--container-sm` — for text-heavy pages |
| `.container-lg` | Same but max-width `--container-lg` — for header/footer |
| `.section` | 2.5rem vertical padding |
| `.grid` | Auto-fill grid, min 16rem per column |
| `.grid[data-columns="2\|3\|4"]` | Fixed column grid with responsive breakpoints |
| `.cluster` | Flex row, wraps, gap via `--gap` — tags, button groups |
| `.repel` | Space-between flex row — logo + nav, label + value |
| `.switcher` | 2 equal columns → stacks below `--switcher-target-container-width` |
| `.flow` | Vertical margin between direct children via `--flow-space` |
| `.flow-recursive` | Same but for all descendants |
| `.box` | White card with 2rem padding and `--radius-md` |

Each layout accepts CSS variable overrides inline:

```html
<div class="cluster" style="--gap: 0.5rem">...</div>
<div class="flow" style="--flow-space: 2rem">...</div>
<div class="switcher" style="--switcher-target-container-width: 60rem">...</div>
```

### Breakpoints

```scss
@include sm { } // max-width: 390px
@include md { } // max-width: 768px
@include lg { } // max-width: 991px
@include xl { } // max-width: 1200px
```

### Live Style Reference

Visit `/BaseStyle/` on any environment to see every token, layout primitive, button, and form element rendered live with the actual theme CSS.

---

## Helper Functions

| Function | Usage |
|----------|-------|
| `get($field)` | `get_field()` wrapper; pass `true` as second arg for options |
| `get_array_value($arr, $key, $default)` | Safe array access with fallback |
| `get_inline_svg($name)` | Returns contents of `assets/icons/{name}.svg` |
| `get_image_src($name)` | Returns URL to `assets/images/{name}` |

---

## Claude Code Commands

The theme ships with AI-assisted slash commands in `.claude/commands/`. Run them with `/command-name` in Claude Code.

| Command | What it does |
|---------|-------------|
| `/add_block [name]` | Scaffolds ACF fields, layout registration, SCSS, JS, and template |
| `/add_cpt [name]` | Creates a Custom Post Type |
| `/add_taxonomy [details]` | Creates a custom taxonomy |
| `/add_acf [target]` | Creates an ACF field group |
| `/add_ajax [action]` | Creates an AJAX handler |
| `/add_shortcode [name]` | Creates a shortcode |
| `/add_helper [details]` | Creates a helper function |
| `/update_basestyle` | Syncs `/BaseStyle/` page with the latest SCSS changes |
