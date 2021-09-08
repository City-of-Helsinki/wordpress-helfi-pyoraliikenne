<?php

              $args = array(
                  'posts_per_page' => -1
              );

              $query = new WP_Query($args);
              $q = array();

              while ( $query->have_posts() ) {

                  $query->the_post();
                  $article_slug = get_the_title();
                  $article_slug = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $article_slug);
                  $article_slug = sanitize_title($article_slug);

                  $categories = get_the_category();

                  foreach ( $categories as $key=>$category ) {
                    $b = '<a href="' . get_category_link( $category ) . '" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' . $category->name . ' <span class="caret"></span></a>';
                  }

                  $a = '<a href="' . get_category_link( $category ) . '#'. $article_slug .'">' . get_the_title() .'</a>';

                  $q[$b][] = $a; // Create an array with the category names and post titles
              }
              /* Restore original Post Data */
              wp_reset_postdata();

?>

<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" id="mobile-navbar-toggle" class="navbar-subnav-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <i class="fa fa-fw fa-2x"></i></button>
          <?php if (get_post_type() == 'blog') { ?>
            <img src="<?php echo get_template_directory_uri() . '/dist/images/PLBmerkki.png' ?>" alt="plbmerkki" class="mobile-banner-img">
          <?php  } else {?>
          <a class="navbar-brand" href="/">Pyöräliikenteen suunnitteluohje</a>
          <?php  }?>
        </div>
        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
          <ul class="nav navbar-nav">
              <?php
              wp_nav_menu( array(
                'menu' => 'menu-site-navigation',
                'menu_class' => 'menu-site-navigation-mobile',
                'menu_id' => 'menu-site-navigation-mobile'
              ) );
              ?>
              <?php
              foreach ($q as $key=>$values) {
                  echo '<li class="dropdown">';
                  echo $key;
                  echo '<ul class="dropdown-menu">';
                      foreach ($values as $value){
                          echo '<li>' . $value . '</li>';
                      }
                  echo '</ul>';
                  echo '</li>';
              }
              ?>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
</nav>

<script type="text/javascript">

jQuery('.dropdown-menu>li>a').click(function(){
  jQuery('#mobile-navbar-toggle').click();

});

function setMobileNavHeight() {

  var mobileWindowHeight = jQuery( window ).height()-50;
  jQuery('.navbar-fixed-top .navbar-collapse').css("max-height", mobileWindowHeight);

}

  jQuery(window).resize(function() {
    setMobileNavHeight();
  });

jQuery(document).ready(function () {

    setMobileNavHeight();

});

</script>
