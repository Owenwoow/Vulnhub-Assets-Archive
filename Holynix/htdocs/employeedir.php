<?php
if ( $auth == 0 ) {
        echo "<center><h2>Content Restricted</h2></center>";
} else {
	echo "<div align='center'><h3>Employee Directory</h3></div>";
	echo "<form method=\"POST\" action=\"index?page=employeedir.php\">";
	echo "<p>Order By:<select size='1' name='order'>";
	echo "<option value='name'>Name";
	echo "</option>";
	echo "<option selected value='surname'>Surname";
	echo "</option>";
	echo "<option value='department'>Department";
	echo "</option>";
	echo "<p><input type='submit' value='Reorder'></p>";
	echo "</form>";
	$orderby=$_REQUEST['order'];
	if ( $orderby <> "" ) { $query  = "SELECT * FROM employee ORDER BY " .$orderby; } else { $query  = "SELECT * FROM employee"; }
	$result = mysql_query($query) or die('<b>SQL Error:</b>' . mysql_error($conn) . '<p><b>SQL Statement:</b>' . $query);
	if (mysql_num_rows($result) > 0) {
		echo "<table border='1' cellpadding='0' cellspacing='0'>";
		while($row = mysql_fetch_row($result)) {
			echo "<tr><td><table width='750'><tr><td>";
			echo $row[1]. " " .$row[2]. "<br /> ";
			echo "Department: " .$row[3]. "<br /> ";
			echo $row[4]. "<br /> ";
			echo $row[5]. "<br /><br /><br />";
			echo "</td><td>";
			echo "<div align='right'><img src='" .$row[6]. "' /></div>";
			echo "</td></tr></table></td></tr>";
		}
	echo "</table>";
	}
}
?>
