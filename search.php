<?php get_template_part('templates/page', 'header'); ?>

<div class="search-form-wrapper">
<?php if (!have_posts()) : ?>
  <h2>Ei tuloksia</h2>
  <?php endif; ?>
  <?php get_search_form(); ?>
</div>

<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/content', 'search'); ?>
<?php endwhile; ?>

<?php the_posts_navigation(array( 'prev_text' => 'Lisää hakutuloksia', 'next_text' => 'Takaisin' ));
 ?>