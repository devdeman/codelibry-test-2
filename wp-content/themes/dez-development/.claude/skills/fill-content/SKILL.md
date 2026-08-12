---
name: fill-content
description: Fills content into a WordPress site from a Figma node URL, screenshot, or text description — using a targeted PHP script. Use this skill when the user wants to fill a specific block with real content, populate a page, create posts, update existing posts, or update ACF fields/options. Trigger on: "fill this block", "put content into this page", "update the hero section", "create these products", "update this post", "fill in the ACF fields", "fill from Figma", "populate from this design", "add content based on this screenshot". Also trigger when the user points to a design and says what WordPress element to fill (page, block, post, options).
---

# Fill Content

## Why this skill exists

`seed-content` populates an empty site wholesale. This skill does the opposite: it takes a **specific design reference** (Figma URL, screenshot, or text description) and fills a **targeted WordPress element** with content that matches the design — a single block, a full page, a set of posts, or ACF fields.

**Core pattern:** write a self-contained PHP script (`fill-content.php`) at the WordPress root that bootstraps via `wp-load.php`, applies the content changes using WP/ACF APIs, then self-deletes. Run it with `php fill-content.php` from the WP root.

---

## Step 1 — Extract content from the input

### From a Figma URL
1. Parse `fileKey` and `nodeId` from URL:
   - `figma.com/design/:fileKey/:name?node-id=:nodeId` — convert dashes to colons in nodeId (`1-2` → `1:2`)
   - `figma.com/design/:fileKey/branch/:branchKey/...` — use `branchKey` as fileKey
2. Call `get_design_context` with `fileKey + nodeId` to get text content, labels, and structure.
3. Use the screenshot and any Code Connect hints to identify content: headings, body copy, button labels, image descriptions, stats, lists.
4. If `get_design_context` fails, fall back to `get_screenshot` and describe content from the image.

### From a screenshot or image
Identify and list all visible text content: headings, subheadings, body copy, button labels, captions, list items, stats, and any image alt descriptions. This becomes the content spec.

### From a text description
Use the description directly as the content spec. Ask for clarification if field targets are ambiguous.

---

## Step 2 — Identify the target

Ask the user (or infer from context):

1. **Which element to fill?**
   - A single block within a page
   - All blocks on a page (full page fill)
   - New posts/CPTs to create
   - Existing posts to update
   - ACF options fields

2. **Which page/post/option?** (get title, slug, or ID)

3. **Which block layout?** (for single-block fills — get the `acf_fc_layout` name, e.g. `hero`)

Read the relevant ACF definition files to know the exact field names:
- Block fields: `inc/acf/blocks/{block-name}.php`
- Page template: `inc/acf/templates/page-blocks.php` (flexible content field name)
- CPT fields: `inc/acf/post-types/{cpt}.php`
- Options: `inc/acf/options/{page}.php`

---

## Step 3 — Write the fill script

Create `fill-content.php` in the WordPress root. Use only the sections relevant to the task — don't include unused modes.

### Script skeleton

```php
<?php
/**
 * Fill content — run with: php fill-content.php
 */
require_once __DIR__ . '/wp-load.php';

echo "Filling content...\n";

// === YOUR FILL CODE HERE ===

echo "\n✓ Done.\n";
@unlink(__FILE__);
```

---

## Mode 1 — Fill a single block

Update one layout entry within a page's flexible content. Preserves all other layouts.

```php
// Resolve the page
$page = get_page_by_path('home'); // or get_page_by_title(), or use ID directly
$page_id = $page->ID;

// Load existing flexible content
$blocks = get_field('page_blocks', $page_id) ?: [];

// Find the target layout index
$target_index = null;
foreach ($blocks as $i => $block) {
    if ($block['acf_fc_layout'] === 'hero') {
        $target_index = $i;
        break;
    }
}

// If the block doesn't exist yet, append it; if it does, update in place
$hero_data = [
    'acf_fc_layout'       => 'hero',
    'hero-title'          => 'Your Headline Here',
    'hero-subtitle'       => 'Supporting badge or tagline',
    'hero-description'    => 'Body copy supporting the headline.',
    'hero-button-1'       => ['title' => 'Primary CTA', 'url' => '/shop/', 'target' => ''],
    'hero-button-2'       => ['title' => 'Secondary CTA', 'url' => '/about/', 'target' => ''],
];

if ($target_index !== null) {
    $blocks[$target_index] = $hero_data;
    echo "  Updated existing 'hero' block.\n";
} else {
    $blocks[] = $hero_data;
    echo "  Appended new 'hero' block.\n";
}

update_field('page_blocks', $blocks, $page_id);
echo "  Saved page blocks for: {$page->post_title}\n";
```

---

## Mode 2 — Fill a full page

Replace all flexible content on a page with a complete set of blocks from the design.

```php
$page = get_page_by_path('home');
$page_id = $page->ID;

// Build the full block sequence from the design
$blocks = [
    [
        'acf_fc_layout'    => 'hero',
        'hero-title'       => 'Main Headline',
        'hero-description' => 'Supporting copy.',
        'hero-button-1'    => ['title' => 'Shop Now', 'url' => '/shop/', 'target' => ''],
    ],
    [
        'acf_fc_layout'   => 'features',
        'features-title'  => 'Why Choose Us',
        'features-items'  => [
            ['features-item-title' => 'Speed', 'features-item-text' => 'Fast delivery.'],
            ['features-item-title' => 'Quality', 'features-item-text' => 'Premium materials.'],
        ],
    ],
    // ... add all blocks visible in the design
];

update_field('page_blocks', $blocks, $page_id);
echo "  Set " . count($blocks) . " blocks on: {$page->post_title}\n";
```

> Use `inc/acf/blocks/*.php` to look up every field name. The flexible content field is named `page_blocks` (use underscores in `update_field`, not dashes).

---

## Mode 3 — Create posts / CPTs

```php
$entries = [
    [
        'title'    => 'John Smith',
        'fields'   => [
            'author-position' => 'Senior Developer',
            'content'         => 'Fantastic tool. Saved us weeks of work.',
        ],
    ],
    // add more entries from the design
];

foreach ($entries as $entry) {
    // Idempotency: skip if already exists
    $existing = get_page_by_title($entry['title'], OBJECT, 'testimonials');
    if ($existing) {
        echo "  Skipping (exists): {$entry['title']}\n";
        continue;
    }

    $post_id = wp_insert_post([
        'post_title'  => $entry['title'],
        'post_status' => 'publish',
        'post_type'   => 'testimonials', // replace with target CPT slug
    ]);

    foreach ($entry['fields'] as $field => $value) {
        update_field($field, $value, $post_id);
    }

    echo "  Created: {$entry['title']} (ID {$post_id})\n";
}
```

---

## Mode 4 — Update existing posts

```php
// Find by title or slug
$post = get_page_by_title('About Us', OBJECT, 'page');
// or: $post = get_page_by_path('about-us');
// or: $post = get_post(42); // by ID

if (!$post) {
    echo "  Post not found.\n";
} else {
    // Update core fields if needed
    wp_update_post([
        'ID'           => $post->ID,
        'post_title'   => 'Updated Title',   // omit if unchanged
        'post_content' => '<p>New content.</p>', // omit if ACF-driven
    ]);

    // Update ACF fields
    update_field('hero-title', 'New Headline', $post->ID);
    update_field('hero-description', 'Updated copy.', $post->ID);

    echo "  Updated: {$post->post_title}\n";
}
```

---

## Mode 5 — Update ACF options

```php
// Options page fields — always pass 'option' as the second argument
update_field('header-cta-label', 'Start Free Trial', 'option');
update_field('header-cta-url', '/register/', 'option');

update_field('footer-description', 'Brief company tagline for footer.', 'option');
update_field('footer-email', 'hello@example.com', 'option');

// Repeater on options
update_field('social-links', [
    ['platform' => 'instagram', 'url' => 'https://instagram.com/example'],
    ['platform' => 'twitter',   'url' => 'https://x.com/example'],
], 'option');

echo "  Options updated.\n";
```

> Check `inc/acf/options/*.php` for exact field names on each options page.

---

## Step 4 — Locate the WordPress root and run

The WP root is 5 levels up from the theme directory. Confirm it contains `wp-load.php`:

```
{theme}/                           ← you are here
  ../../                           ← themes/
  ../../../                        ← wp-content/
  ../../../../                     ← public/  (WordPress root)
```

Or just check: if the theme is at `.../app/public/wp-content/themes/skins2go-ai`, the root is `.../app/public/`.

```bash
# Place and run the script
cp fill-content.php /path/to/wordpress-root/
cd /path/to/wordpress-root/
php fill-content.php
```

The script prints each action and self-deletes. If it errors before completing:
```bash
rm fill-content.php
```

---

## Content quality bar

Content must read as real — not placeholder text:

- **Headings**: clear, benefit-led, specific to the niche
- **Body copy**: natural sentences, relevant to the page context
- **CTAs**: action-oriented labels matching the design ("Start Free Trial", not "Click Here")
- **Repeater items**: realistic entries with varied detail, not "Item 1 / Item 2"
- **Stats**: plausible numbers with context ("14,000+ happy customers")
- **Options**: real-looking company name, plausible contact info and social handles

---

## ACF field name reference

`update_field()` accepts field names (not keys). Names are kebab-case with a block prefix:
- `hero-title`, `hero-description`, `hero-button-1`
- `features-items` (repeater) → sub-fields: `features-item-title`, `features-item-text`

The flexible content field on page templates is `page_blocks` (underscore, not dash) — see `inc/acf/templates/page-blocks.php`.

For ACFComposer-generated keys (rarely needed):
```
field_{groupName}_{fieldName}
field_{groupName}_{flexFieldName}_{layoutName}_{subFieldName}
```
