<html>
<head>
<title>Phake Organization Registration</title>
</head>
<body>
<?php 
if (isset($email)) {
	$link = mysql_connect('localhost', 'root', 'mysqlpassword');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo '<!-- Connected successfully -->';
mysql_select_db("contacts") or die('Could not select database');
$query = "insert into contact set name='$name', email='$email', phone='$phone', org='$org'";
mysql_query($query) or die('Query error' . mysql_error());
mysql_close($link);
echo "<h2>Thank you for registering!</h2>";
echo "<p>You have successfully been added to our contact database.</p>";
echo "<p>Click <a href='../index.php'>here</a> to return to our homepage.</p>";
}
else {
?>
<h2>Register with Phake Organization</h2>
<p>Please take a moment to register with Phake Organization.  We 
collect information about our clients and event registrants in order
to facilitate better, faster communication among stakeholders.  All
information will be kept strictly confidential!</p>
<table>
<form method="post">
<tr>
	<td>Your name:</td><td><input type="text" name="name"/></td></tr>
	<td>Your email:</td><td><input type="text" name="email"/></td></tr>
	<td>Your phone number:</td><td><input type="text" name="phone"/></td></tr>
	<td>Your organization:</td><td><input type="text" name="org"/></td></tr>
</table>
<input type="submit" value="Register Now!"/>
</form>
<?php 
}
?>
</body>
</html>