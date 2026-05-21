<div class="clear-block"><div class="comment-picture"><?php print $picture ?></div>
<div class="comment-outer"><div class="comment<?php print ($comment->new) ? ' comment-new' : ''; print ($comment->status == COMMENT_NOT_PUBLISHED) ? ' comment-unpublished' : ''; ?> clear-block">
<div class="comment1"><div class="comment2">
<?php if ($comment->new) : ?>
  <a id="new"></a>
  <span class="new"><?php print $new ?></span>
<?php endif; ?>

  <div class="submitted">
    <?php print $submitted ?>
  </div>
 <span class="clear"></span>
  <div class="content">
    <?php print $content ?>
  </div>

  <?php print $links ?>
</div></div></div></div></div>
