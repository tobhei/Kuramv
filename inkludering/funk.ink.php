<?php


function emptyInputLogin($username, $pwd) {
    $result;
    if (empty($username) || empty($pwd)) {
      $result = true;  
    } else {
        $result = false;
    }
    return $result;
}

function loginUser($conn, $username, $pwd) {
    $uidExists = uidExists($conn, $username, $username);
    
    if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login.php?error=felaktigt_lösenord");
        exit();
    } elseif ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["userId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["admin"] = $uidExists["administrator"];
        header("location: ../profilsida.php");
        exit();
    }
}
function emptyInputSignup($fnamn, $enamn, $email, $username, $pwd, $pwdRepeate) {
    $result;
    if (empty($fnamn) || empty($enamn) || empty($email) || empty($username) || empty($pwd) || empty($pwdRepeate)) {
      $result = true;  
    } else {
        $result = false;
    }
    return $result;
}

function invalidUid($username) {
    $result;
    if (!preg_match("/^[a-öA-Ö0-9]*$/", $username)) {
      $result = true;  
    } else {
        $result = false;
    }
    return $result;
}
function  pwdMatch($pwd, $pwdRepeate) {
    $result;
    if ($pwd !== $pwdRepeate) {
      $result = true;  
    } else {
        $result = false;
    }
    return $result;
}
function uidExists($conn, $username, $email) {
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit(); 
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
        
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $fnamn, $enamn, $email, $username, $pwd) {
    $sql = "INSERT INTO users (usersFname, usersEname, usersEmail, usersUid, usersPwd) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit(); 
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssss", $fnamn, $enamn, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}
function updateUser($conn, $fnamn, $enamn, $email, $pwd) {

    $sql = "UPDATE users SET fnamn=$_POST[usersFname], enamn=$_POST[usersEname], email=$_POST[usersEmail],pwd=$_POST[usersPwd] WHERE userid='$userId'";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profilsida.php?error=stmtfailed");
        exit(); 
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssss", $fnamn, $enamn, $email, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../profilsida.php?error=none");
    exit();
}
function emailExists($conn, $email) {
    $sql = "SELECT * FROM users WHERE usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../profilsida.php?error=stmtfailed");
        exit(); 
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
        
    } else {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}
