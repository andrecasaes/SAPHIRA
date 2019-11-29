<?php
$link = mysqli_connect("localhost", "root", "", "test");
// $link = new mysqli("10.100.116.219", "w86petsi", "M-Pj1c4n", "w86petsi");
// mysql_set_charset('utf8');

if (!$link) {
   	echo "Failed to connect to MySQL: ".mysqli_connect_errno() . PHP_EOL;
}
?>