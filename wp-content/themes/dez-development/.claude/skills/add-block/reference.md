# Reference: ACF Block Scaffolding

Use these snippets as defaults when generating a new block.

## 1) ACF Fields File

Path: `inc/acf/blocks/{block}.php`

```php
<?php

function codelibry_acf_fields_my_block(): array {
    return [
        [
            'label' => 'Title',
            'name'  => 'my-block-title',
            'type'  => 'text',
        ],
        [
            'label' => 'Text',
            'name'  => 'my-block-text',
            'type'  => 'wysiwyg',
            'tabs'  => 'all',
        ],
        [
            'label'         => 'Image',
            'name'          => 'my-block-image',
            'type'          => 'image',
            'return_format' => 'id',
            'preview_size'  => 'medium',
            'library'       => 'all',
        ],
        [
            'label' => 'Button Text',
            'name'  => 'my-block-button-text',
            'type'  => 'text',
        ],
        [
            'label' => 'Button Url',
            'name'  => 'my-block-button-url',
            'type'  => 'url',
        ],
    ];
}
```

Rules:
- no ACF `key`
- function name in snake_case from block slug
- field names in kebab-case with block prefix

## 2) Register Layout In Flexible Content

Add to `layouts` in `inc/acf/templates/page-blocks.php`:

```php
[
    'name'       => 'my-block',
    'label'      => 'My Block',
    'display'    => 'block',
    'sub_fields' => codelibry_acf_fields_my_block(),
],
```

If user requests reusable block support, add the same entry in:
- `inc/acf/post-types/reusable-blocks.php`

## 3) Template File

Path: `template-parts/blocks/my-block.php`

```php
<?php
$title      = get_array_value($args, 'my-block-title', get('my-block-title'));
$text       = get_array_value($args, 'my-block-text', get('my-block-text'));
$image_id   = get_array_value($args, 'my-block-image', get('my-block-image'));
$button_txt = get_array_value($args, 'my-block-button-text', get('my-block-button-text'));
$button_url = get_array_value($args, 'my-block-button-url', get('my-block-button-url'));
?>

<section class="my-block section">
    <div class="container">
        <div class="my-block__inner | switcher">
            <div class="my-block__content | flow" style="--flow-space: 1rem;">
                <?php if ($title): ?>
                    <h2><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($text): ?>
                    <div class="content">
                        <?php echo wp_kses_post($text); ?>
                    </div>
                <?php endif; ?>

                <?php if ($button_txt && $button_url): ?>
                    <a class="button" href="<?php echo esc_url($button_url); ?>">
                        <?php echo esc_html($button_txt); ?>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($image_id): ?>
                <div class="my-block__media">
                    <?php echo wp_get_attachment_image((int) $image_id, 'full'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
```

## 4) SCSS Partial

Path: `src/scss/blocks/_my-block.scss`

```scss
.my-block {
  background-color: var(--color-light);

  &__inner {
    --switcher-target-container-width: 64rem;
    align-items: center;
    gap: 2rem;
  }

  &__content {
    max-width: 42rem;
  }

  &__media {
    img {
      @include image-cover;
      border-radius: var(--radius-md);
      min-height: 20rem;
      width: 100%;
    }
  }
}
```

Then import in `src/scss/main.scss` under `/* Blocks */`:

```scss
@import "blocks/my-block";
```

## 5) Optional JS Module

Path: `src/js/my-block.js`

```js
export default function MyBlock() {
  const nodes = document.querySelectorAll('.my-block');

  if (!nodes.length) return;

  nodes.forEach((node) => {
    node.dataset.ready = 'true';
  });
}
```

Wire in `src/main.js`:

```js
import MyBlock from './js/my-block';

document.addEventListener('DOMContentLoaded', () => {
  MyBlock();
});
```

Only add JS when interaction is needed.

## 6) Sanitization Matrix

- text/heading -> `esc_html`
- textarea/wysiwyg -> `wp_kses_post`
- url/link -> `esc_url`
- attribute value -> `esc_attr`
- numeric id -> cast to `(int)` before output

## 7) Figma URL Parsing and Mapping

If input is a Figma URL, parse with these defaults:

- `figma.com/design/:fileKey/:name?node-id=:nodeId`
  - use `fileKey` as file key
  - convert node id dashes to colons (`12-345` -> `12:345`)
- `figma.com/design/:fileKey/branch/:branchKey/:name`
  - use `branchKey` as file key
- `figma.com/board/:fileKey/:name`
  - this is FigJam, not a design frame

Mapping rules for this theme:
- convert colors/typography/spacing to existing `var(--...)` tokens first
- avoid raw absolute positioning unless functionally required
- prefer `container/section/flow/grid/switcher/cluster/repel` patterns
- keep BEM naming aligned with block slug

## 8) Final Validation Checklist

Before finishing, verify:

- file names match slug across all generated paths
- `codelibry_acf_fields_*` function exists and is referenced in layout registration
- layout exists in `page-blocks.php` (and reusable file if requested)
- template uses `get_array_value` fallback reads
- template output is escaped properly per field type
- new SCSS partial is imported in `main.scss`
- no unnecessary new tokens when existing ones fit
- commands suggested to user: `npm run build` (and optionally `npm start`)
