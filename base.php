<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>
<?php if(is_page_template( 'template-custom-redirect.php' )) {

  $args = get_posts(array(
    'post_type' => 'blog',
    'numberposts' => 1,
  ));
  wp_redirect( get_permalink($args[0]->ID) ); exit;
} else {

 ?>

<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>

    <!-- Matomo -->
      <script type="text/javascript">
        var _paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(["setCookieDomain", "*.pyoraliikenne.fi"]);
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
          var u="//analytics.hel.ninja/";
          _paq.push(['setTrackerUrl', u+'matomo.php']);
          _paq.push(['setSiteId', '29']);
          var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
          g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
        })();
      </script>
    <!-- End Matomo Code -->

    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      get_template_part('templates/header');
    ?>
    <div class="wrap container-fluid" role="document">
      <div class="content row">
        <?php if (Setup\display_sidebar()) : ?>
          <aside class="sidebar">
            <?php include Wrapper\sidebar_path(); ?>
          </aside><!-- /.sidebar -->
        <?php endif; ?>
        <?php if (!is_front_page() && !is_404()) : ?>
        <?php get_template_part('templates/sub-navigation'); ?>
        <?php endif; ?>

        <?php get_template_part('templates/search-popup'); ?>

        <main class="main">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    <?php
      do_action('get_footer');
      get_template_part('templates/footer');
      wp_footer();
    ?>
  <!-- BEGIN Snoobi v1.4 -->
  <script type="text/javascript" src="http://eu1.snoobi.com/snoop.php?tili=pyoraliikenne_fi"></script>
  <!-- END Snoobi v1.4 -->
  </body>
</html>
<?php } ?>
