<?php
include "helpers/header.php";
?>

    <!DOCTYPE html>
    <html lang="se">
    <head>
        <meta charset="UTF-8">
        <title>Varor</title>
    </head>
    <body>
<?php
if(isset($_SESSION['userid'])){
    $conn = include "setup.php";
    $stmta = $conn->prepare("SELECT * FROM {$dbname}.bestallningar WHERE kundnummer = ?");


    $stmta->bind_param("s",$_SESSION['userid']);
    $stmta->execute();
    $result = $stmta->get_result();
    echo "<a>Ordrar<br></a>";
    while ($row2 = $result->fetch_assoc()) {
        echo "<a href='ordersida.php?orderNummer=".$row2['ordernummer']."'>".$row2['ordernummer']."<br></a>";
    }




}else{
    echo "<a href='login.php'>Du är inte inlogad, Vänligen logga in</a>";
}

if ($_GET('orderNummer' != "")){
    $stmta = $conn->prepare("SELECT * FROM {$dbname}.bestalldaVaror WHERE kundnummer = ?");


    $stmta->bind_param("s",$_SESSION['userid']);
    $stmta->execute();
    $result = $stmta->get_result();
    echo "<a>Ordrar<br></a>";
    while ($row2 = $result->fetch_assoc()) {
        echo "<a href='ordersida.php?orderNummer=".$row2['ordernummer']."'>".$row2['ordernummer']."<br></a>";
    }
}
