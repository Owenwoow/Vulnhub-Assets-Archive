<?php 
include_once("inc/header.php");

// Include the page contents
if (isset($page)) {
	include_once("inc/$page.php");
}
else {
	include_once("inc/index.php");
}

include_once("inc/footer.php");

?>
