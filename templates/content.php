<?php
$post = get_post();
$article_slug = $post->post_name; ?>

<a class="anchor" id="<?php echo $article_slug ?>"></a>
<article <?php post_class(); ?>>
  <header>	

  	<?php
  	$obj = get_post_type_object( get_post_type() );
  	if ( $obj->labels->singular_name == 'Ohjeisto' ) { ?>
  	<h2 class="entry-title"><?php the_title(); ?></h2>
  	<?php } else {?>
    <?php if ( has_post_thumbnail() ) { ?>
    <?php $post_img_urls = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); ?>
    <div class="single-cover-img" style="background-image: url('<?php echo $post_img_urls[0]; ?>');"></div>
    <?php } ?>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <div class="post-date">Julkaistu: <?php the_time('j.n.Y') ?></div>
    <?php } ?>

  </header>
  <div class="entry-summary">
    <?php the_content(); ?>
  </div>
</article>