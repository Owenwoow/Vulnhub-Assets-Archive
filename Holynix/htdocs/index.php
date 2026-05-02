<?php
include ("header.php");
// Grab inputs
$page = $_GET[page];
if ($page=="") { include ("home.php"); }
else {
        $query = "SELECT location FROM page WHERE location = '". $page ."'";
        $result = mysql_query($query);
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        if ( file_exists($row{'location'}) ) { include($row{'location'}); } else { include("404.html"); }

}
include ("footer.php");
?>
