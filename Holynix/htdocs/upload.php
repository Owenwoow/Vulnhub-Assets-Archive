<?php
if ( $auth == 0 ) {
        echo "<center><h2>Content Restricted</h2></center>";
} else {
	echo "<h3>Home Directory Uploader</h3>";
	echo "<form enctype='multipart/form-data' action='index.php?page=transfer.php' method='POST'>";
	echo "Please choose a file: <input name='uploaded' type='file' /><br />";
	echo "<input type='checkbox' name='autoextract' value='true' /> Enable the automatic extraction of gzip archives.<br>";
	echo "<input type='submit' value='Upload' /></form>";
}
?>
