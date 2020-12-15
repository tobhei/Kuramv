<?php

$conn = include '../setup.php';

    if(isset($_SESSION['userid'])){

    $stmt = $conn->prepare("SELECT * FROM {$dbname}.varukorg WHERE kundnummer = ? AND VaruID = ?");


    $stmt->bind_param("ss",$_SESSION['userid'],$_POST["varuid"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {

        $stmt = $conn->prepare("INSERT {$dbname}.varukorg(`kundnummer`, `VaruID`, `Antal`) VALUES ?,?,?");


        $stmt->bind_param("iss",$_SESSION['userid'],$_POST["varuid"],1);
        $stmt->execute();

    }

    }


    header("location: ". $_SERVER['HTTP_REFERER']);

