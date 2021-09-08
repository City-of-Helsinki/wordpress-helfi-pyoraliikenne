<?php get_template_part('templates/page', 'header'); ?>

<?php 
wp_reset_query();
$categories = get_the_category();
$category_id = $categories[0]->cat_ID;
query_posts( array ( 'posts_per_page' => -1, 'cat' => $category_id) ); 
?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>
<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
<?php endwhile; ?>

<?php wp_reset_query(); ?>

<?php
if (!get_post_type()=='post') {
the_posts_navigation();
} ?>