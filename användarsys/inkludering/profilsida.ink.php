<?php

if (isset($_POST["submit"])) {

    $fnamn = $_POST["fnamn"];
    $enamn = $_POST["enamn"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeate = $_POST["pwdrepeat"];

    require_once 'dbpek.ink.php';
    require_once 'funk.ink.php';

if (emailExists($conn, $email) !== false) {
    header("location: ../signup.php?error=emailtaken");
    exit();
    } 
if (pwdMatch($pwd, $pwdRepeate) !== false) {
    header("location: ../signup.php?error=passwordsdontmatch");
    exit();
    } 
    updateUser($conn, $fnamn, $enamn, $email, $pwd);

} else {
    header("location: ../profilsida.php");
    exit();
}

