<?php

$serverName = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "d0018e";

$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


