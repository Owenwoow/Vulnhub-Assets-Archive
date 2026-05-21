<?php 
function phptemplate_body_class($sidebar_left, $sidebar_right) {
  if ($sidebar_left != '' && $sidebar_right != '') {
    $class = 'sidebars';
  }
  else {
    if ($sidebar_left != '') {
      $class = 'sidebar-left';
    }
    if ($sidebar_right != '') {
      $class = 'sidebar-right';
    }
  }

  if (isset($class)) {
    print ' class="'. $class .'"';
  }
}



function admire_gray_regions() {
  return array(
       'header' => t('Header'),
	   'sidebar_left' => t('Sidebar left'),
	   'content_top' => t('Content top'),
	   'sidebar_right' => t('Sidebar right'),
	   'footer_block' => t('Footer block'),
  );
}