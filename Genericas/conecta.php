<?php
// $link = mysqli_connect("localhost", "root", "", "test");
$mysqli = new mysqli("10.100.116.219", "w86petsi", "M-Pj1c4n", "w86petsi");

if (!$link) {
   	echo "Failed to connect to MySQL: ".mysqli_connect_errno() . PHP_EOL;
}
?>