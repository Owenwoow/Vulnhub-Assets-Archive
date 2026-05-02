<?php
if ( $auth == 0 ) {
        echo "<center><h2>Content Restricted</h2></center>";
} else {
	echo "<center><h4><b>Standard Security Practices</b></h4></center><p>";
	echo "<form method=\"POST\" action=\"" .$_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'] . "\">";

	echo "<p><select size='1' name='text_file_name'>";
	echo "<option value='ssp/email.txt'>Email";
	echo "</option>";
	echo "<option value='ssp/acceptable_use.txt'>Acceptable Use";
	echo "</option>";
	echo "<option value='ssp/internet_use.txt'>Internet Use";
	echo "</option>";
	echo "<option value='ssp/software_installation.txt'>Software Installation";
	echo "</option>";
	echo "<option value='ssp/malware.txt'>Malware";
	echo "</option>";
	echo "<option value='ssp/auditing.txt'>Auditing";
	echo "</option>";
	echo "</select></p>";
	echo "<p><input type='submit' value='Display File' name='B'></p>";
	echo "</form>";
	echo "<pre>";

	$textfilename=$_REQUEST["text_file_name"];

	if ($textfilename <>"") {
		$handle = fopen($textfilename, "r");
		echo stream_get_contents($handle);
		fclose($handle);
	}
	echo "</pre>";
}
?>
