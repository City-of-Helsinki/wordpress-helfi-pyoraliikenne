<?php use Roots\Sage\Titles; ?>

<?php if (is_page()) : ?>
	<div class="page-header">
	  <h2><?= Titles\title(); ?></h2>
	</div>
<?php endif; ?>