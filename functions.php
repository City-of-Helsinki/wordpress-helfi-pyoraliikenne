<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

/**
 * Hide Admin bar
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Change default post name
 */
function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Ohjeisto';
    $submenu['edit.php'][5][0] = 'Ohjeisto';
    $submenu['edit.php'][10][0] = 'Lisää kappale';
    echo '';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Ohjeisto';
    $labels->singular_name = 'Ohjeisto';
    $labels->add_new = 'Lisää kappale';
    $labels->add_new_item = 'Lisää kappale';
    $labels->edit_item = 'Editoi';
    $labels->new_item = 'Uusi';
    $labels->view_item = 'Tarkastele';
    $labels->search_items = 'Etsi';
    $labels->not_found = 'Ei tuloksia';
    $labels->not_found_in_trash = 'Ei tuloksia';
    $labels->all_items = 'Kaikki';
    $labels->menu_name = 'Ohjeisto';
    $labels->name_admin_bar = 'Ohjeisto';
}

add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );



// search filter
function fb_search_filter($query) {
if ( !$query->is_admin && $query->is_search) {
$query->set('post_type', array('post') ); // id of page or post
}
return $query;
}
add_filter( 'pre_get_posts', 'fb_search_filter' );

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page();

}
