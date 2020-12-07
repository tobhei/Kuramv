<?php

if (isset($_POST["submit"])) {
    require_once 'dbpek.ink.php';
    require_once 'funk.ink.php';
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];



    if (emptyInputLogin($username, $pwd) !== false) {
        header("location: ../login.php?error=emptyinput");
        exit();
    }
    loginUser($conn, $username, $pwd);

    } else {
    header("location: ../login.php");
    exit();
}
