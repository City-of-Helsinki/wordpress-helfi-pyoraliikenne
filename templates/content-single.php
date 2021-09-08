<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <?php if ( has_post_thumbnail() ) { ?>
      <?php $post_img_urls = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); ?>
      <div class="single-cover-img" style="background-image: url('<?php echo $post_img_urls[0]; ?>');"></div>
      <?php } ?>
      <h2 class="entry-title"><?php the_title(); ?></h2>
      <?php if (get_post_type()=='uutiset' || get_post_type()=='blogi') { ?>
      <div class="post-date">Julkaistu: <?php the_time('j.n.Y') ?></div>
      <?php } ?>
    </header>
    <div class="entry-content">
    <?php the_content(); ?>
    </div>
    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
    <?php comments_template('/templates/comments.php'); ?>
  </article>
<?php endwhile; ?>
