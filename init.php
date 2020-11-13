<?php
$conn = include 'setup.php';


echo $dbname."<br>";

$initDB = "CREATE DATABASE IF NOT EXISTS {$dbname}";



$result = $conn->query($initDB);
if ($result === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating Database: " . $conn->error."<br>";
}


$inituser = "CREATE TABLE IF NOT EXISTS {$dbname}.anvandare(
id INTEGER not null unique,
username TEXT,
`Fornamn` TEXT,
Efternamn TEXT,
Medlem_sedan DATE,
Senaste_inlogg DATE,
Profilbild TEXT,
`Losenord` TEXT,
Email TEXT,
PRIMARY KEY (id));";

$result = $conn->query($inituser);
if ($result === TRUE) {
    echo "  inituser: Table created successfully<br>";
} else {
    echo "Error creating Table: " . $conn->error."<br>";
}

$initVaror = "CREATE TABLE IF NOT EXISTS {$dbname}.Varor(
VaruID CHAR(8) not null unique ,
Namn VARCHAR(60) not null ,
Pris INT(255) not null DEFAULT 0,
Antal INT(255) DEFAULT 0,
ResourceURL TEXT,
Rating DECIMAL(2,1) not null DEFAULT 0,
PRIMARY KEY(VaruID)
)";

$result = $conn->query($initVaror);
if ($result === TRUE) {
    echo "initvaror: Table created successfully<br>";
} else {
    echo "Error creating Table: " . $conn->error."<br>";
}

$initVarukorg = "CREATE TABLE IF NOT EXISTS {$dbname}.varukorg(
kundnummer INTEGER not null,
VaruID CHAR(8) not null,
Antal INT(255) not null DEFAULT 0,
FOREIGN KEY (VaruID) REFERENCES {$dbname}.Varor(VaruID),
FOREIGN KEY (kundnummer) REFERENCES {$dbname}.anvandare(id), 
PRIMARY KEY (kundnummer, VaruID));";
$result = $conn->query($initVarukorg);
if ($result === TRUE) {
    echo "Table Varukorg created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error."<br>";
}








/*

$getUser = "SELECT id FROM {$dbname}.anvandare";

$resu = $conn->query($getUser);


$getVara = "SELECT VaruID FROM {$dbname}.Varor";

    while ($row = $resu->fetch_row()) {
        $resul = $conn->query($getVara);
        if($resul === FALSE){
            echo "FALSE";
        }
        while ($row2 = $resul->fetch_row()) {
           // printf("%s %s\n", $row[0], $row2[0]);
            $dbq = "INSERT INTO {$dbname}.varukorg(kundnummer,VaruId) VALUES ( {$row[0]} , '{$row2[0]}' )";
            echo $dbq. "<br>";
            $r = $conn->query($dbq);
            if(!($r === TRUE)){
                echo $row[0] . "   ". $row2[0]."   ".$conn->error. "<br>";
            };

        }
        $resul->close();
    }
    $resu->close();
*/






