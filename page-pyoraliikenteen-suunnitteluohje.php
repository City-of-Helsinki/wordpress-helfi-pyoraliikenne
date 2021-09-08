<?php $post_img_urls = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); ?>
<div class="page-cover-img" style="background-image: url('<?php echo $post_img_urls[0]; ?>');">
<img class="logo-hki" src="<?php echo get_template_directory_uri() . '/dist/images/logo-hki.png'?>" alt="Helsingin Kaupunki Logo">
<div class="page-cover-title">
<?php if (have_posts()) : while (have_posts()) : the_post();?>
<?php the_content(); ?>
<?php endwhile; endif; ?>
</div>
</div>
<?php 
$args = array(
    'category_name' => 'ohjeen-kayttajalle'
);
 
$query = new WP_Query( $args );
?>
<?php while ($query->have_posts()) : $query->the_post(); ?>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>
