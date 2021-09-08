<?php

$dynamic_author = get_field('dynamic_authors');

$author_array = Roots\Sage\Extras\get_author_data($dynamic_author);

$post_ID = get_the_ID();

while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>
    <header>
      <?php if ( has_post_thumbnail() ) { ?>
      <?php $post_img_urls = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large'); ?>
      <div class="single-cover-img" style="background-image: url('<?php echo $post_img_urls[0]; ?>');"></div>
      <?php } ?>
      <h2 class="entry-title"><?php the_title(); ?></h2>
      <?php if (get_post_type()=='blog') { ?>
      <div class="post-author"><strong><?php echo $author_array['name']; ?></strong></div>
      <div class="post-date">Julkaistu: <?php the_time('j.n.Y') ?></div>
      <div class="post-categories">
        <?php
          $taxonomy = 'blog_category';
          $terms = get_the_terms($post->ID, $taxonomy);
          if ( $terms && !is_wp_error( $terms ) ) :
  ?>
      <ul>
          <?php foreach ( $terms as $term ) { ?>
              <li><a href="<?php echo get_term_link($term->slug, $taxonomy); ?>"><?php echo $term->name; ?></a></li>
          <?php } ?>
      </ul>
  <?php endif;?>
      </div>
      <?php } ?>
    </header>
    <div class="entry-content">
    <?php the_content(); ?>
    </div>
    <div class="container author-block">
			<div class="row">
				<div class="col-sm-12 no-padding">
					<div class="author-image" style="background-image:url(<?php echo $author_array['image']; ?>);">
					</div>
					<div class="author-information">
						<p><?php echo $author_array['titteli']; ?></p>
						<p><strong><?php echo $author_array['name']; ?></strong></p>
						<p><?php echo $author_array['description']; ?></p>
            <?php if ($author_array['instagram_linkki'] || $author_array['twitter_linkki']) { ?>
              <ul class="social-links">
              <?php if ($author_array['twitter_linkki']) { ?>
                <li><span class="twitter"></span><a href="<?php echo $author_array['twitter_linkki'] ?>">@<?php echo $author_array['twitter_kayttajatunnus'] ?></a></li>
              <?php  } ?>
              <?php if ($author_array['instagram_linkki']) { ?>
                <li><span class="ig"></span><a href="<?php echo $author_array['instagram_linkki'] ?>">@<?php echo $author_array['instagram_kayttaja'] ?></a></li>
            <?php  } ?>
              </ul>
          <?php  } ?>
					</div>
				</div>
			</div>
      <div class="row">
        <div class="col-md-12 socials-block">
          <h4>Jaa kirjoitus</h4>
          <?php
            if ( function_exists('some_napit') ) {
              $context['social_buttons'] = array(
                  some_napit('Twitter', get_the_permalink($current_id), __('Twitter', 'text-domain')),
                  some_napit('LinkedIn', get_the_permalink($current_id), __('LinkedIn', 'text-domain')),
                  some_napit('Facebook', get_the_permalink($current_id), __('Facebook', 'text-domain'))
              );
            }
            if ( function_exists('some_napit_inline_styles') ) {
              $context['social_styles'] = some_napit_inline_styles(
                  '.single-blog',
                  'L10-Regular,sans-serif',
                  '400',
                  '1.4rem'
              );
}
           ?>
           <ul class="social-share">
             <?php foreach ( $context['social_buttons'] as $some ) { ?>
                 <li><?php echo $some ?></li>
             <?php } ?>
           </ul>
        </div>
      </div>
    </div>
    <?php comments_template('/templates/blog-comments.php'); ?>
      <?php

    $featposts = get_posts(array(
  	'numberposts'	=> 3,
  	'post_type'		=> 'blog',
  	'meta_query'	=> array(
  		array(
  			'key'	 	=> 'dynamic_authors',
  			'value'	  	=> array($author_array['name']),
  			'compare' 	=> 'IN',
  		),
  	),
    'post__not_in' => array ($post->ID),
  ));

      foreach($featposts as $featpost) {

      $posts_data[] = array(
        'title' => get_the_title($featpost->ID),
        'link' => get_the_permalink($featpost->ID),
        // 'name' => $author_array['name'],
        'date' => get_the_date('j.n.Y', $featpost->ID)
      );

  }

  if ( $posts_data ) :
  ?>
  <div class="container related-posts authors-posts">
    <h4>Lisää samalta kirjoittajalta</h4>
  <?php foreach($posts_data as $posted) { ?>
    <div class="row">
      <div class="col-md-12">
        <div class="site--feature-content post-categories">
          <span class="site--meta">
            <?= $posted['date'] ?>
          </span>
          <h3 class="feature-title"><a href="<?= $posted['link'] ?>"><?= $posted['title'] ?></a></h3>
        </div>
      </div>
    </div>
   <?php } ?>
       </div> <?php
  // endwhile;
  // //echo '</ul>';
  // endif;
  // // Reset Post Data
  // wp_reset_postdata();
  ?>
  <?php endif;?>

		<div id="other-posts" class="container related-posts">
      <h2>Muut kirjoitukset</h2>
			<?php
        $custom_request = new \WP_REST_Request( 'GET', '/pyoraliikenne/v1/posts' );
        $custom_request->set_query_params( [ 'offset' => 0 ] );
        $custom_request->set_query_params( [ 'id' => $post_ID] );
        $custom_response = rest_do_request( $custom_request );
        $custom_server = rest_get_server();
        $html = $custom_server->response_to_data( $custom_response, false );
        if ($html['html']) {
          echo implode('', $html['html']);
        } else{
          echo "<strong>Lisää kirjoituksia tulossa pian...</strong>";
        }
  			?>
		</div>
    <?php if ($html['amilast'] == false): ?>
      <div class="more-posts">
        <a href="#" id="get-data" data-offset="1" data-id="<?php echo $post_ID ?>">Näytä lisää blogikirjoituksia</a>
      </div>
    <?php endif; ?>

    <footer>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  </article>
<?php endwhile; ?>
