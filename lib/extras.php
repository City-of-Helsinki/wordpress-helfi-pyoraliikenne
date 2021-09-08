<?php

namespace Roots\Sage\Extras;

use Roots\Sage\Setup;

/**
 * Add <body> classes
 */
function body_class($classes) {
  // Add page slug if it doesn't exist
  if (is_single() || is_page() && !is_front_page()) {
    if (!in_array(basename(get_permalink()), $classes)) {
      $classes[] = basename(get_permalink());
    }
  }

  // Add class if sidebar is active
  if (Setup\display_sidebar()) {
    $classes[] = 'sidebar-primary';
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
  if (!is_search()) {
    return ' &hellip; <strong><a href="' . get_permalink() . '">' . __('Lue lisää', 'sage') . '</a></strong>';
  }
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

function my_repair_categories_empty_title($title, $instance, $base) {
    if ( $base == 'categories' ) {
        if ( trim($instance['title']) == '' )
            return '';
    }
    return $title;
}
add_filter('widget_title', __NAMESPACE__ . '\\my_repair_categories_empty_title', 10, 3); // added namespace because of error

function acf_populate_authors($field) {

  $authors = array();

  $field['choices'] = array();
  $field['choices'][0] = 'Älä näytä kirjoittajaa';

  if( have_rows('authors', 'option', false) ):
    while ( have_rows('authors', 'option', false) ) : the_row();
      $authors[] = get_sub_field('nimi');
    endwhile;
  endif;

  if( is_array($authors) ) {
    foreach( $authors as $author ) {
      $field['choices'][ $author ] = $author;
    }
  }

  return $field;

}

add_filter('acf/load_field/name=dynamic_authors', __NAMESPACE__ . '\\acf_populate_authors');

function get_author_data($dynamic_author) {

  $author_array = array();

  if( have_rows('authors', 'option', false) ):
    while ( have_rows('authors', 'option', false) ) : the_row();

      $authors_name = get_sub_field('nimi');

      if($authors_name == $dynamic_author) {
        $author_image = get_sub_field('kuva');

        // $author_image = $author_image ? $author_image['sizes']['square-400'] : get_template_directory_uri() . '/dist/images/default-user-image.png';

        $author_array = array(
          'name' => $authors_name,
          'image' => $author_image,
          'description' => get_sub_field('esittely'),
          'titteli' => get_sub_field('titteli'),
          'instagram_kayttaja' => get_sub_field('instagram_kayttaja'),
          'instagram_linkki' => get_sub_field('instagram_linkki'),
          'twitter_kayttajatunnus' => get_sub_field('twitter_kayttajatunnus'),
          'twitter_linkki' => get_sub_field('twitter_linkki')
        );
      }

    endwhile;
  endif;

  return $author_array;
}

add_image_size( 'square-400', 400, 400, true );

function pyoraliikenne_get_posts_arguments() {
    $args = array();
    $args['offset'] = array(
      'description' => esc_html__( 'Offset', 'pyoraliikenne' ),
      'type'        => 'int'
    );
    $args['id'] = array(
      'description' => esc_html__( 'Post ID', 'pyoraliikenne' ),
      'type'        => 'int'
    );
    return $args;
  }

function pyoraliikenne_register_routes() {
   register_rest_route( 'pyoraliikenne/v1', '/posts', array(
     'methods'  => \WP_REST_Server::READABLE,
     'callback' => __NAMESPACE__ . '\\pyoraliikenne_get_posts_html',
     'args' => pyoraliikenne_get_posts_arguments(),
   ) );
   }

add_action( 'rest_api_init', __NAMESPACE__ . '\\pyoraliikenne_register_routes' );

function pyoraliikenne_get_posts_html( $request ) {

  $news_data = array();

  if ($request['offset'] == 0) {

    $full = 4;

    // arguments - otetaan kolme postausta sivulatauksella jolloin offset on 0
    $args = array(
      'post_type' => 'blog',
      'offset'   => 0,
      'post_status' => 'publish',
      'posts_per_page' => $full, // you may edit this number
      'orderby' => 'DESC',
      'post__not_in' => array ($request['id']),
    );

  }else{

    $full = 5;

    // arguments - otetaan yksi edellinen ja 3 seuraavaa postausta ja näytetään vain kolme. Offset on suurempi kuin 0.
    $args = array(
      'post_type' => 'blog',
      'offset'   => $request['offset'] ? $request['offset'] * 3 - 1: 0,
      'post_status' => 'publish',
      'posts_per_page' => $full, // you may edit this number
      'orderby' => 'DESC',
      'post__not_in' => array ($request['id']),
    );

  }


  $related_posts = get_posts($args);

  $previous_item_month = null;
  $lastpost = (sizeof($related_posts) !== $full) ? true : false;

  $related_posts_counter = 0;
  foreach($related_posts as $item) {

      $this_array = array(
       'title' => get_the_title($item->ID),
       'image' => get_the_post_thumbnail_url($item->ID),
       'link' => get_the_permalink($item->ID),
       'excerpt' => strip_tags(strtok($item->post_content, "\n\n")),
       'name' => get_field('dynamic_authors', $item->ID),
       'category' => wp_get_post_terms($item->ID, 'blog_category'),
       'date' => get_the_date('j.n.Y', $item->ID),
       'heading_date' => '<h3>' . get_the_date('Y/m', $item->ID) . '</h3>'
     );

     if($previous_item_month == $this_array['heading_date']) {
       $this_array['heading_date'] = null;
     }

     if($this_array['heading_date'] !== null) {
       $previous_item_month = $this_array['heading_date'];
     }

    if($related_posts_counter !== 0 || $request['offset'] == 0) {
      if($related_posts_counter !== ($full - 1)) {
        $news_data[] = $this_array;
      }
    }

    $related_posts_counter++;
  }

foreach($news_data as $item) {
  $categories = $item['category'];
  $news_category = array();
  $item['name'] = $item['name'] ? '<span>'. $item['name'] .'</span>' : null;
  foreach ($categories as $cat) { $news_category[] ='<li class="title"><a href="'. get_term_link($cat) .'">'. $cat->name .'</a></li>'; }
  $news_html[] ='
  <div class="row">
    '. $item['heading_date'] .'
    <div class="col-md-7">
      <div class="feature-content">
       <div class="feature-image" style="background-image: url(' . $item['image'] . ')"></div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="post-categories">
        '. $item['name'] .'
        <span class="site--meta">
        '. $item['date'] .'
        </span>
        <h3 class="feature-title"><a href=" '. $item['link'] .' "> '. $item['title'] .'</a></h3>
        <p class="feature-excerpt">'. $item['excerpt'] .'</p>
        <ul class="feature-categories">'. implode('', $news_category) .'</ul>
      </div>
    </div>
  </div>';
 }
  return array(
      'html' => $news_html,
      'amilast' => $lastpost
  );
       }
