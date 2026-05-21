<?php
echo("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php print $head_title ?></title>
    <?php print $head ?>
    <?php print $styles ?>
    <?php print $scripts ?>
<!--[if IE]>
<style type="text/css"> 
/* place css fixes for all versions of IE in this conditional comment */
.page #sidebar1, .page #sidebar2 { padding-top: 30px; }
.page #mainContent { zoom: 1; padding-top: 15px; }
/* the above proprietary zoom property gives IE the hasLayout it needs to avoid several bugs */
</style>
<![endif]-->
</head>
<body>
     <div id="pagecontainer">
	    <!-- Top Tabs -->
	    <div id="toptabs">
		<p>Site Network: </p>
		<?php print phptemplate_andreas02_primarylinks($primary_links); ?>
	    </div>
	    <!-- end #toptabs -->
	    	    
	    <!-- start #container -->
		<div id="container">
		<!-- start #logo -->
		<div id="logo">
		<?php if ($logo) { ?><a href="<?php print check_url($base_path); ?>" title="<?php print t('Home') ?>"><img src="<?php print $logo ?>" alt="<?php print t('Home') ?>" /></a><?php } ?>
		    <h1><a href="<?php print check_url($base_path); ?>"><?php print check_plain($site_name); ?></a></h1>
		    <?php if ($site_slogan) { ?><h2><?php print $site_slogan ?></h2><?php } ?>
		</div>
		<!-- end #logo -->
		<!-- start #navitabs -->
		<div id="navitabs">
		    <?php  print phptemplate_andreas02_primarylinks(menu_primary_links(2));  ?>
		</div>
		<!-- end #navitabs -->
		<!-- start #desc -->
		<div id="desc">
	    
		    <?php 
		    if ($main_block != ""): 
			print $main_block;
		    endif;
		    ?> 

		</div>
		<!-- end #desc -->
		<!-- start #main -->
		<div id="main">
		    <?php if ($mission != ""): ?>
			<div id="mission"><?php print $mission ?></div>
		    <?php endif; ?>
		    <?php print $header; ?>
		    <?php if ($title != ""): ?>
			<h2><?php print $title ?></h2>
		    <?php endif; ?>
		    <?php if ($breadcrumb) { ?><div class="breadcrumb"><?php print $breadcrumb ?></div><?php } ?>
		    <?php if ($tabs != ""): ?>
			<?php print $tabs ?>
		    <?php endif; ?>
		    <?php if ($help != ""): ?>
			<p id="help"><?php print $help ?></p>
		    <?php endif; ?>
		    <?php if ($messages != ""): ?>
			<?php print $messages ?>
		    <?php endif; ?>
		    <?php print($content) ?>
		</div>
		<!-- end #main -->
	      
		<!-- start #sidebar -->
		<div id="sidebar">
		    <?php if ($sidebar): ?>
			<?php print $sidebar; ?>
		    <?php endif; ?>	
		</div>
		<!-- end #sidebar -->

		<!-- start #footer -->
		<div id="footer">
		    <p><?php print $footer_message ?>&middot; Drupal port by <a href="http://www.nickbits.co.uk">Nick Young</a> &middot; Design by <a href="http://andreasviklund.com/">Andreas Viklund</a></p>
		</div>
		<!-- end #footer -->
	    </div>
	    <!-- end #container -->
	</div>
<?php
print $closure
?>
</body>
</html>