<?php
	$query  = "SELECT * FROM blogs_table ORDER BY date ASC";
	$result = mysql_query($query) or die('<p><b>SQL Error:</b>' . mysql_error($conn) . '<p><b>SQL Statement:</b>' . $query);;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		echo "<p><b>{$row['blogger_name']}:</b>({$row['date']})<br>{$row['comment']}</p>";
	}
	echo "<p>";
?>
<?php
echo "<form method=\"POST\" action=\"" .$_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'] . "\">";
?>

	<p><textarea rows="10" cols="100" name="input_from_form" size="20"></textarea></p>
	<p><input type="submit" value="Submit" name="Submit_button"></p>
</form>

<?php
$inputfromform = $_REQUEST["input_from_form"];

if ($inputfromform  <> "") {
	$query = "INSERT INTO blogs_table(blogger_name, comment, date) VALUES ('".
		$logged_in_user . "', '".
		$inputfromform  . "', " .
		" now() )";


	$result = mysql_query($query);
	echo '<meta http-equiv="refresh" content="0;url=' .$_SERVER['SCRIPT_NAME'] . "?" . $_SERVER['QUERY_STRING'] . '">';
}
?>


