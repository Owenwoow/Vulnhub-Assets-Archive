<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/2002/REC-xhtml1-20020801/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language ?>" xml:lang="<?php print $language ?>">
<head>
  <title><?php print $head_title ?></title>
  <?php print $head ?>
  <?php print $styles ?>
  <?php print $scripts ?>
  <!--[if lt IE 7]>
    <link rel="stylesheet" href="<?php print $base_path . $directory; ?>/ie.css" type="text/css">
  <![endif]-->
</head>
<body class="<?php print $body_classes; ?>">
<div id="body2">
<a name="top"></a>
  <div id="wrapper">
  <div id="header"> 
     <?php if ($site_name) { ?><h1 class='site-name'>
      <a href="<?php print $base_path ?>" title="<?php print t('Home') ?>">
      <?php print $site_name ?></a></h1>
    <?php } ?> 
    <?php if ($logo) { ?><div id="logo"><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><img src="<?php print $logo ?>" alt="<?php print t('Home') ?>" /></a></div><?php } ?>
    <div id="primary">
    <?php print preg_replace('/<a (.*?)>(.*?)<\\/a>/i','<a \\1><span>\\2</span></a>',theme('links', $primary_links, array('class' =>'links', 'id' => 'navlist'))); ?></div>
    </div>
  <div id="page">
  </div>
  <div id="page2"><div id="page3">
    <div id="main" class="clearfix"><div id="main2">
      <?php if ($mission) { ?><div id="mission"><div id="mission2"><?php print $mission ?></div></div><?php } ?>
      <div class="inner">
        <?php print $breadcrumb ?>
        <h1 class="title"><?php print $title ?></h1>
        <?php if ($tabs){ ?><div class="tabs"><?php print $tabs ?></div><?php } ?>
        <?php print $help ?>
        <?php if ($messages): print $messages; endif; ?>
        <?php print $content; ?>
        <?php print $feed_icons; ?>
      </div>
    </div></div>
    <?php if ($sidebar_right): ?>
      <div id="sidebar-right" class="clearfix">
      <?php print $sidebar_right ?>
      </div>
    <?php endif; ?>
    <br clear="all"/>
    <span class="clear"></span>
  </div>
  </div>
  </div>
  </div>
  <div id="footer">
  <?php print $footer_message;?><br/>
  </div>
  <div id="footer2">
  <a href="http://www.fireandknowledge.org">Theme</a> <a href="http://www.avioso.com">port</a> sponsored by Duplika <a href="http://www.duplika.com">Web Hosting</a>.</div>
  <div id="footer3"><span><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><?php print t('Home') ?></a></span> <span><a href="#top"><?php print t('Back To Top') ?></a></span></div>
  <?php print $closure ?>
  
</body>
</html>
