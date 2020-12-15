<?php

//$serverName = "utbweb.its.ltu.se";
//$dbUsername = "990907";
//$dbPassword = "990907";
//$dbName = "D0018ELABB";
$conn = include 'setup.php';

$conn->select_db($dbname);
//$conn = mysqli_connect($serverName, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
return $conn;

