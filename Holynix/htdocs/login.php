<center><h2><b>User Login</b></h2></center>
<?php
if ($failedloginflag==1) {
	echo '<h2><font color="#ff0000">Bad user name or password!</font></h2>';
	echo "If you continue to have problems logging in contact<br />the system administrator at ltorvalds@example.net<br /><br />";
}
echo "<form method=\"POST\" action=\"" .$_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'] . "\">";
?>
	<p>Enter your username and password:</p>
	<p>Name:<br><input type="text" name="user_name" size="20"></p>
	<p>Password:<br><input type="password" name="password" size="20"></p>
	<p><input type="submit" value="Submit" name="Submit_button"></p>
</form>
<?php
?>
