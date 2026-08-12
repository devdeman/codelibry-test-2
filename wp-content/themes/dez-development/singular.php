<?php get_header(); ?>

<?php
global $post;
$post_slug = $post->post_name;
?>

<main class="main" id="main">
  <div class="singular-page">
      <div class="container-sm">
                <h1 class="singular-page__title | h2">
                    <?php the_title(); ?>
                </h1>

            <div class="content">
                <?php the_content(); ?>
            </div>
      </div>
  </div>
</main>

<?php get_footer();?>
