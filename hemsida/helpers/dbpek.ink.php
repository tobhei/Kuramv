<?php

$serverName = "utbweb.its.ltu.se";
$dbUsername = "990907";
$dbPassword = "990907";
$dbName = "D0018ELABB";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>



