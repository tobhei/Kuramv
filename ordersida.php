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
    echo "<a>Ordrar<br></a><table>";
    echo "<table>
         <tr>
           <th>Ordernummer</th>
           <th>Beställnings Datum</th>
           <th>Leverans Email</th> 
         </tr>
         ";
    while ($row2 = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<th><a href='ordersida.php?orderNummer=".$row2['ordernummer']."'>".$row2['ordernummer']."<br></a></th>";
        echo "<th>".$row2['bestallningsDatum']."</th>";
        echo "<th>".$row2['LeveransEmail']."</th>";
        echo "</tr>";
    }
    echo "</table>";



}else{
    echo "<a href='login.php'>Du är inte inlogad, Vänligen logga in</a>";
}

$ordnum = $_GET["orderNummer"];
if (isset($ordnum)) {
    if ($ordnum != "") {
        $stmta = $conn->prepare("SELECT * FROM {$dbname}.bestalldaVaror WHERE ordernummer = ?");


        $stmta->bind_param("s", $ordnum);
        $stmta->execute();
        $result = $stmta->get_result();
        echo "<a>Ordrer: ".$ordnum ."<br></a>";
        echo "<table>
         <tr>
           <th>Ordernummer</th>
           <th>Vara</th>
           <th>Antal</th> 
           <th>Pris</th>
         </tr>
         ";

        while ($row2 = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<th><a href='ordersida.php?orderNummer=" . $row2['ordernummer'] . "'>" . $row2['ordernummer'] . "<br></a></th>";
            echo "<th><a href='resource/" . $row2['VaruID'] . "/vara.php'>" . $row2['VaruID'] . "</a></th>";
            echo "<th>".$row2['Antal']."</th>";
            echo "<th>".$row2['Pris']."</th>";
            echo "</tr>";


        }
        echo "</table>";
    }
}
