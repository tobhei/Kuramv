<?php

if (isset($_POST["submit"])) {
    require_once 'dbpek.ink.php';
    require_once 'funk.ink.php';

    $fnamn = $_POST["fnamn"];
    $enamn = $_POST["enamn"];
    $email = $_POST["email"];
    $username = $_POST["uids"];
    $pwd = $_POST["pwd"];
    $pwdRepeate = $_POST["pwdrepeat"];



    if (emptyInputSignup($fnamn, $enamn, $email, $username, $pwd, $pwdRepeate) !== false) {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (invalidUid($username) !== false) {
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if (pwdMatch($pwd, $pwdRepeate) !== false) {
        header("location: ../signup.php?error=passwordsdontmatch");
        exit();
    }


    $test = uidExists($conn, $username, $email);
    if ( $test !== false) {

        header("location: ../signup.php?error=usernametaken");
        exit();
    }
    createUser($conn, $fnamn, $enamn, $email, $username, $pwd);

} else {
    header("location: ../signup.php");
    exit();
}