<?php
	$query  = "SELECT * FROM calender ORDER BY eventdate ASC";
	$result = mysql_query($query) or die('<p><b>SQL Error:</b>' . mysql_error($conn) . '<p><b>SQL Statement:</b>' . $query);;
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		echo "<p><b>Event Date:</b>(" .$row['eventdate']. ")<br>" .$row['comment']. "</p>";
	}
	echo "<p>";
?>
