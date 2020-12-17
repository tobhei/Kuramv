<?php
session_start();
$conn = include '../setup.php';

    if(isset($_SESSION['userid'])){

    $stmt = $conn->prepare("SELECT * FROM {$dbname}.varukorg WHERE kundnummer = ? AND VaruID = ?");

    $stmt->bind_param("is",$_SESSION['userid'],$_POST["varuid"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {

        $stmt = $conn->prepare("INSERT {$dbname}.varukorg VALUES (?,?,?)");
        $antal = 1;
        $stmt->bind_param("isi",$_SESSION['userid'],$_POST["varuid"],$antal);
        $stmt->execute();

    }

    }


    header("location: /varuregister.php");

