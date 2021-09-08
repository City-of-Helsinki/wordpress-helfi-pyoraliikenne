<?php
$is_search_archive = is_search();
$current_cat = 0;
$ispreview = is_preview();
$is_single_post = is_single();
$categories = get_the_category();
$current_cat = $categories[0]->cat_ID;
$current_posttype = get_post_type();
$current_posttype_obj = get_post_type_object( get_post_type());


query_posts( array ( 'posts_per_page' => -1, 'cat' => $current_cat) );
?>

<?php if ($current_posttype == 'post' && $is_search_archive==0) {  ?>
<div class="subnav-wrapper">
  <div class="blue-popup-margin" id="desktop-subnav-popup">
  <button type="button" class="navbar-subnav-toggle" id="blue-popup-toggle" onclick="hide_subnav()"><i class="fa fa-fw fa-3x"></i></button>
  <div class="sub_nav_content_wrapper">
  <h2 class="entry-title"><?php single_cat_title(); ?></h2>
  <ul>
  <?php while (have_posts()) : the_post();
  $post = get_post();
  $article_slug = $post->post_name;
  ?>
  <li><a href="#<?php echo $article_slug ?>"><?php the_title(); ?>&nbsp›</a></li>
  <?php endwhile; ?>
  </ul>
  </div>
  </div>

<?php } ?>

  <div class="navbar-wrapper">

    <?php if ($is_search_archive==1) { ?>
      <h4 class="entry-title">Hakutulokset</h4>
    <?php } else {
      if ($current_posttype == 'post') {
      if ($current_cat != 6) { ?>
      <button type="button" class="navbar-subnav-toggle" onclick="show_subnav()"><i class="fa fa-fw fa-2x"></i></button>
      <?php } ?>
      <h4 class="entry-title">
      <?php single_cat_title(); ?>
      </h4>
    <?php } else if ($current_posttype == 'page') { ?>
      <h4 class="entry-title">
      <?php the_title(); ?>
      </h4>
    <?php } else if ($current_posttype == 'blog') { ?>
      <img src="<?php echo get_template_directory_uri() . '/dist/images/PLBmerkki.png' ?>" alt="plbmerkki">
    <?php } else { ?>
      <h4 class="entry-title">
      <?php echo $current_posttype_obj->labels->name; ?>
      </h4>
    <?php } ?>
    <?php } ?>
  </div>
</div>

<?php wp_reset_query(); ?>

<script type="text/javascript">

var cur_posttype = '<?php echo $current_posttype ?>';
var cur_cat = '<?php echo $current_cat ?>';
var preview = '<?php echo $ispreview ?>';
var single_post = '<?php echo $is_single_post ?>';
var search_archive = '<?php echo $is_search_archive ?>';

function show_subnav() {
  jQuery('html').css('overflow-y', 'hidden');
	jQuery('#desktop-subnav-popup').css({ 'display': 'block' });
}

function hide_subnav() {
  jQuery('html').css('overflow-y', 'auto');
	jQuery('#desktop-subnav-popup').css({ 'display': 'none' });
}

function show_subnav_on_certain_pages() {
  if(window.location.href.indexOf("#") == -1 && single_post != 1 && search_archive != 1 && cur_cat != 6 && cur_posttype == 'post') {
        show_subnav();
  }
}

show_subnav_on_certain_pages();

jQuery('#desktop-subnav-popup ul li a').click(function(){
	 hide_subnav();
    jQuery('html, body').animate({
        scrollTop: jQuery( jQuery.attr(this, 'href') ).offset().top
    }, 900);
});

jQuery(window).resize(function() {
    jQuery('#desktop-subnav-popup').height(jQuery( window ).height())
});

jQuery(document).ready(function () {

  show_subnav_on_certain_pages();

});

</script>
