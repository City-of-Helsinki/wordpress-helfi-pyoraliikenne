<?php 
dynamic_sidebar('sidebar-primary');
$isFrontPage = 0;
if ( is_front_page() ) { $isFrontPage = 1;} 
?>

<script type="text/javascript">

function setSidebarBrandHeight() {
	var windowHeight = jQuery( window ).height();
   windowHeight = parseInt(windowHeight);

   if (parseInt(windowHeight) < 700) {
      jQuery('.sidebar-brand img, .sidebar-logo-txt br:first-of-type').css('display', 'none'); // LOGO + eka <br> piiloon
      jQuery('.sidebar-logo-txt').css('top', '30%');
      
   } else {
      jQuery('.sidebar-brand img, .sidebar-logo-txt br:first-of-type').css('display', 'inline-block');
      // jQuery('.sidebar-logo-txt').css('top', '50%');
   }

   if (parseInt(windowHeight) > 850) {
      windowHeight = 850;
   }

	sidebarBrandHeight = windowHeight - parseInt(jQuery('.widget_categories').height()) - parseInt(jQuery('.menu-site-navigation-container').height()) - 150;
	jQuery('.sidebar-brand').height(sidebarBrandHeight);
   jQuery('.sidebar-logo-txt').css('-ms-transform', 'translate(-50%, -50%)');
	sidebarBrandPadding = sidebarBrandHeight * 0.25;
}

setSidebarBrandHeight();

jQuery(document).ready(function () {
 
   jQuery(window).resize(function() {
 		setSidebarBrandHeight();
	});

   jQuery('.cat-item-9 a').attr("href", "/");

   var is_Frontpage = <?php echo $isFrontPage ?>;

   if (is_Frontpage) {
   jQuery('.cat-item-9').addClass("current-cat");
   }

   setSidebarBrandHeight();

});

</script>