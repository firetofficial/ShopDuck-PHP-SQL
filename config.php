<?php
$host = "localhost";
$userName = "u588161474_admin";
$password = "Bn96ipeh7&";
$dbName = "u588161474_gdu";
// Create database connection
$connect = mysqli_connect($host, $userName, $password, $dbName);
// Check connection
if ($connect->connect_error) {
die("Connection failed: " . $connect->connect_error);
}
?>