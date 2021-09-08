<?php
if (post_password_required()) {
  return;
}
?>

<section id="comments" class="comments">
  <?php if (have_comments()) : ?>
    <h3><?php printf(_nx('Yksi kommentti artikkeliin &ldquo;%2$s&rdquo;', '%1$s kommenttia artikkeliin &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'sage'), number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>'); ?></h3>

    <ol class="comment-list">
      <?php wp_list_comments(['style' => 'ol', 'short_ping' => true]); ?>
    </ol>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
      <nav>
        <ul class="pager">
          <?php if (get_previous_comments_link()) : ?>
            <li class="previous"><?php previous_comments_link(__('&larr; Vanhemmat kommentit', 'sage')); ?></li>
          <?php endif; ?>
          <?php if (get_next_comments_link()) : ?>
            <li class="next"><?php next_comments_link(__('Uudemmat kommentit &rarr;', 'sage')); ?></li>
          <?php endif; ?>
        </ul>
      </nav>
    <?php endif; ?>
  <?php endif; // have_comments() ?>

  <?php if (!comments_open() && get_comments_number() != '0' && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="alert alert-warning">
      <?php _e('Kommentointi on suljettu.', 'sage'); ?>
    </div>
  <?php endif; ?>

<?php $comment_args = array(
  'title_reply'=>'Kommentoi',
  'fields' => apply_filters( 'comment_form_default_fields', array(
  'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Nimi' ) . '</label> ' . ( $req ? '<span>*</span>' : '' ) .
  '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
  'email' => '<p class="comment-form-email">' .
  '<label for="email">' . __( 'Sähköpostiosoite' ) . '</label> ' .
  ( $req ? '<span>*</span>' : '' ) .
  '<input id="email" name="email" type="text" value="noreply@pyoraliikenne.fi" size="30"' . $aria_req . ' />'.'</p>',
  'url' => '' ) ),
);

comment_form($comment_args); ?>

</section>
