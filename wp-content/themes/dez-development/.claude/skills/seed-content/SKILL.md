---
name: seed-content
description: Seeds realistic, niche-appropriate content into a WordPress site. Automatically discovers the theme's CPTs, ACF blocks, ACF options pages, and WooCommerce setup, then generates and runs a standalone PHP seed script — no WP-CLI required, works on any server. Use this skill whenever the user asks to "fill in content", "seed content", "add dummy content", "populate the site", "add sample data", "create test content", or wants to make a blank WordPress site look like a real one. Also trigger when the user says the site is empty or they need content to work with. This skill handles the full chain — theme analysis, content generation, script execution, and cleanup.
---

# Seed Content

## Why this skill exists

A blank WordPress theme is hard to design, demo, or test against. This skill turns a fresh install into a populated, realistic site by reading the theme's own structure and generating niche-appropriate content — not Lorem Ipsum, but copy that would appear on a real site in this industry.

**Core pattern:** write a self-contained PHP script that bootstraps WordPress via `wp-load.php`, runs all seeding using WP/ACF/WooCommerce APIs, then self-deletes. Run it with `php seed-content.php` from the WordPress root. No WP-CLI, no server-specific tooling — just PHP CLI.

---

## Step 1 — Discover the theme structure

Read these files before writing any content:

**CPTs** — `inc/post-types/*.php`
Note each post type slug.

**ACF Blocks** — `inc/acf/blocks/*.php`
For each block function, note all field names, types, and sub-fields.

**ACF Templates** — `inc/acf/templates/page-blocks.php`
Note which layouts are available and what the flexible content field is named (e.g. `page-blocks`).

**ACF CPT groups** — `inc/acf/post-types/*.php`
Note field names for each CPT.

**ACF Options** — `inc/acf/options/*.php`
Note each options page and its fields.

**WooCommerce** — If `inc/woocommerce-hooks/` or `woocommerce/` overrides exist, plan product categories and products.

---

## Step 2 — Infer the site niche

From the theme name, existing page titles, ACF field labels, and any existing copy, build a one-line niche brief:

> "CS2 skin marketplace" / "boutique yoga studio" / "real estate agency" / "SaaS landing page"

This governs all content. No Lorem Ipsum. No "Company Name" placeholders. Write copy that would appear on a real site — authentic product names, industry-specific stats, natural-sounding testimonials.

---

## Step 3 — Plan what to create

**Pages** — Populate the homepage with 3–5 blocks from the available layouts. Create other key pages (About, Contact) if missing.

**CPTs** — 4–6 entries per CPT with realistic content.

**WooCommerce products** — If active: 3–5 product categories + 8–12 products with real names, SKUs, prices (some with sale prices), and small stock quantities.

**Blog posts** — 3 posts with real titles and full article content (300–500 words each).

**Reusable blocks** — If the `reusable-blocks` CPT exists, create 1–2 entries (e.g. a CTA hero).

**ACF options** — Set all options fields: header CTA, footer copy, company info, social links.

---

## Step 4 — Write the seed script

Create `seed-content.php` in the WordPress root.

### Script skeleton

```php
<?php
/**
 * Seed content — run with: php seed-content.php
 * Requires PHP CLI to have access to the same DB as the web server.
 */

require_once __DIR__ . '/wp-load.php';

echo "Starting content seeding...\n";

// === SECTION ===
// ... creation code ...

echo "\n✓ Done.\n";

// Self-delete so it doesn't linger in the webroot
@unlink(__FILE__);
```

That's it — no socket juggling, no WP-CLI phar. The script trusts `wp-config.php` exactly as the running site uses it.

> **Note for developers:** if PHP CLI can't connect to the DB (common on some local setups where the web server uses a socket but CLI defaults to TCP), update `DB_HOST` in `wp-config.php` to the correct value for CLI access, run the script, then restore it. This is an environment concern, not a script concern.

### Idempotency — always check before inserting

```php
// CPT / post — by title
$exists = get_page_by_title('Entry Title', OBJECT, 'cpt_slug');
if ($exists) { echo "  Skipping (exists)\n"; continue; }

// WooCommerce product — by SKU
if (wc_get_product_id_by_sku('MY-SKU')) { echo "  Skipping (exists)\n"; continue; }

// Post — by slug
if (get_page_by_path('my-slug', OBJECT, 'post')) { echo "  Skipping (exists)\n"; continue; }
```

### ACF fields — use field names, not keys

```php
// Post / CPT field
update_field('field-name', $value, $post_id);

// Options page field
update_field('field-name', $value, 'option');

// Repeater
update_field('social_links', [
    ['platform' => 'instagram', 'url' => 'https://instagram.com/example'],
    ['platform' => 'twitter',   'url' => 'https://twitter.com/example'],
], 'option');
```

### Flexible content — append, don't overwrite

```php
$existing = get_field('page-blocks', $page_id) ?: [];
$layouts  = array_column($existing, 'acf_fc_layout');

if (!in_array('hero', $layouts)) {
    $existing[] = [
        'acf_fc_layout'    => 'hero',
        'hero-subtitle'    => 'Badge text',
        'hero-title'       => 'Main Headline',
        'hero-description' => 'Supporting copy here.',
        'hero-button-1'    => ['title' => 'Get Started', 'url' => '/shop/', 'target' => ''],
        'hero-button-2'    => [],
    ];
}

update_field('page-blocks', $existing, $page_id);
```

### WooCommerce products — always use WC_Product_Simple

```php
$product = new WC_Product_Simple();
$product->set_name('Product Name');
$product->set_sku('PROD-001');
$product->set_regular_price('49.99');
$product->set_sale_price('39.99'); // omit if no sale
$product->set_description('<p>Full description.</p>');
$product->set_short_description('Short tagline.');
$product->set_status('publish');
$product->set_catalog_visibility('visible');
$product->set_stock_status('instock');
$product->set_manage_stock(true);
$product->set_stock_quantity(3);
$product->set_category_ids([$cat_id]);
$product_id = $product->save();
echo "  Created: {$product->get_name()} (ID {$product_id})\n";
```

---

## Step 5 — Run the script

```bash
cd /path/to/wordpress-root
php seed-content.php
```

The script prints progress as it runs and self-deletes on completion. If it errors before reaching the self-delete, remove it manually:

```bash
rm seed-content.php
```

---

## Content quality bar

The result should pass a "demo to a client" test:

- **Products**: real industry terminology, not "Product 1 / Product 2"
- **Testimonials**: specific, personal details — not generic "Great service!"
- **Stats blocks**: real-feeling numbers with context ("17% below market", "30,000+ active users")
- **Blog posts**: H2 structure, full paragraphs, internal links to key pages
- **Options**: real company name, plausible social handles, realistic contact details

---

## Reference: ACFComposer key format

`update_field()` accepts field names directly — keys aren't needed. If you ever need them, ACFComposer generates keys as:

```
field_{groupName}_{fieldName}
field_{groupName}_{flexFieldName}_{layoutName}_{subFieldName}
```

Examples from a typical theme:
- `field_pageBlocks_page-blocks_hero_hero-title`
- `field_testimonial_author-name`
- `field_footer_options_footer__description`
