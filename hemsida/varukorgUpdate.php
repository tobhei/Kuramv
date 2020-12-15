<?php
$conn = include 'setup.php';


if($_POST["antal"] == 0){


    $stmt = $conn->prepare("DELETE FROM {$dbname}.varukorg WHERE kundnummer = ? AND VaruID = ?;");


    $stmt->bind_param("is",$_POST["kundnummer"],$_POST["varuid"]);
    $stmt->execute();

    header("location: /varukorg.php");

}else{

   // $getUser = "UPDATE {$dbname}.varukorg SET Antal = {$_GET["antal"]} WHERE kundnummer = {$_GET["kundnummer"]} AND VaruID = {$_GET["varuid"]};";
    $stmt = $conn->prepare("UPDATE {$dbname}.varukorg SET Antal = ? WHERE kundnummer = ? AND VaruID = ?;");


    $stmt->bind_param("iis", $_POST["antal"],$_POST["kundnummer"],$_POST["varuid"]);
    $stmt->execute();

    header("location: /varukorg.php");
}

exit;