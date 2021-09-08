<div class="blue-popup-fullscreen" id="search-popup">
    <button type="button" class="navbar-subnav-toggle" onclick="hide_search_popup()"><i class="fa fa-fw fa-3x"></i></button>
    <div class="search-form-popup">
    <h2 class="entry-title">Hae ohjeistosta</h2>
    <?php get_search_form(); ?>
    </div>
</div>

<script type="text/javascript">

function show_search_popup() {
	jQuery('#search-popup').css({ 'display': 'block' });
  jQuery('html').css('overflow-y', 'hidden');
}

function hide_search_popup() {
	jQuery('#search-popup').css({ 'display': 'none' });
  jQuery('html').css('overflow-y', 'auto');
}

jQuery('.menu-item-120 a').click(function( event ) {
  event.preventDefault();
  show_search_popup();
});

</script>