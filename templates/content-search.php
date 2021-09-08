<?php
  $post = get_post();
  $article_slug = $post->post_name;

  $categories = get_the_category();
  $current_cat = $categories[0]->slug;
 ?>
<article <?php post_class(); ?>>
  <header>
    <h3 class="entry-title"><a href="/<?php echo $current_cat ?>/#<?php echo $article_slug ?>"><?php the_title(); ?></a></h3>
  </header>
  <div class="entry-summary">
    <?php the_excerpt() ?>
    <p><strong><a href="/<?php echo $current_cat ?>/#<?php echo $article_slug ?>">Lue lisää</a></strong></p>
  </div>
</article>