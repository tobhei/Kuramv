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


$inituser = "CREATE TABLE IF NOT EXISTS {$dbname}.users(
userId INTEGER not null unique AUTO_INCREMENT,
usersFname VARCHAR(128),
usersEname VARCHAR(128),
usersEmail VARCHAR(128),
usersPwd VARCHAR(128),
usersUid VARCHAR(128),
UserSince DATE,
lastLogin DATE,
profilePic TEXT,
administrator BOOLEAN, 
PRIMARY KEY (userID));";

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
Betyg DECIMAL(2,1) not null DEFAULT 0,
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
FOREIGN KEY (kundnummer) REFERENCES {$dbname}.users(userId),
PRIMARY KEY (kundnummer, VaruID));";
$result = $conn->query($initVarukorg);
if ($result === TRUE) {
    echo "Table Varukorg created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error."<br>";
}


$initRecensioner = "CREATE TABLE IF NOT EXISTS {$dbname}.recensioner(
kundnummer INTEGER not null,
VaruID CHAR(8) not null,
recension VARCHAR(500),
betyg INTEGER not null,
datum DATE not null,
FOREIGN KEY (VaruID) REFERENCES {$dbname}.Varor(VaruID),
FOREIGN KEY (kundnummer) REFERENCES {$dbname}.users(userId),
PRIMARY KEY (kundnummer, VaruID));";
$result = $conn->query($initRecensioner);
if ($result === TRUE) {
    echo "Table Recensioner created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error."<br>";
}





$initBeställningar = "CREATE TABLE IF NOT EXISTS {$dbname}.bestallningar(
kundnummer INTEGER not null,
ordernummer CHAR(8) not null,
bestallningsDatum DATE,
LeverasEmail VARCHAR(128),
FOREIGN KEY (kundnummer) REFERENCES {$dbname}.users(userId),
PRIMARY KEY (ordernummer));";

$result = $conn->query($initBeställningar);
if ($result === TRUE) {
    echo "Table beställningar created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}


$initBeställdaVaror = "CREATE TABLE IF NOT EXISTS {$dbname}.bestalldaVaror(
ordernummer CHAR(8) not null,
VaruID CHAR(8) not null,
Antal INTEGER not null,
FOREIGN KEY (VaruID) REFERENCES {$dbname}.Varor(VaruID),
FOREIGN KEY (ordernummer) REFERENCES {$dbname}.bestallningar(ordernummer),
PRIMARY KEY (ordernummer, VaruID));";

$result = $conn->query($initBeställdaVaror);
if ($result === TRUE) {
    echo "Table BeställdaVaror created successfully<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}


/*
$getUser = "SELECT userId FROM {$dbname}.users";

$resu = $conn->query($getUser);


$getVara = "SELECT VaruID FROM {$dbname}.Varor";

    while ($row = $resu->fetch_row()) {
        $resul = $conn->query($getVara);
        if($resul === FALSE){
            echo "FALSE";
        }
        while ($row2 = $resul->fetch_row()) {
           // printf("%s %s\n", $row[0], $row2[0]);
            $dbq = "INSERT INTO {$dbname}.varukorg(kundnummer,VaruId,Antal) VALUES ( {$row[0]} , '{$row2[0]}', 2)";
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




