<div class="node<?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">
  <?php if ($picture) {print $picture;}?>
  <?php if ($page == 0) { ?><h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2><?php }; ?>
<div class="node2">
  <?php if ($submitted) { ?><span class="submitted"><?php print $submitted?></span><?php } ?>
  <div class="taxonomy"><?php if ($terms) {print "<b>Published in</b>" . $terms; }?></div>
  </div>
  <span class="clear"></span>
  <div class="content"><?php print $content?></div>
  <?php if ($links) { ?><div class="links-node"><?php print $links?></div><?php }; ?>
</div>
