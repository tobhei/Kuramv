<!DOCTYPE html>
<html lang="en">
<!--Scroll function by https://www.w3schools.com/howto/howto_css_menu_horizontal_scroll.asp-->
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Varukorg</title>

    <style >

        div.scrollmenu {
            overflow: auto;
            white-space: nowrap;

        }

        div.scrollmenu a {
            display: block;
            text-align: center;
            padding: 14px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="scrollmenu">
   <!-- <a href="#home">Home</a>-->

    <?php
    $kundnummer = "231325";
    $conn = include 'setup.php';

    //$stmt = $conn->prepare("SELECT * FROM {$dbname}.varukorg WHERE kundnummer=?");
    //SELECT vk.VaruID, vk.Antal, v.Namn FROM (D0018ELABB.varukorg vk inner join D0018ELABB.Varor v on vk.VaruID = v.VaruID)

    $stmt = $conn->prepare("SELECT vk.VaruID, vk.Antal, v.Namn 
        FROM ((D0018ELABB.varukorg vk)
        inner join D0018ELABB.Varor v on vk.VaruID = v.VaruID) where `kundnummer` = ?");



    if ( $stmt===false ) {
        die('prepare() failed: ' . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("i", $kundnummer);
    $stmt->execute();

    $res = $stmt->get_result();
    while(($row = $res->fetch_assoc()) != false){
        echo "<a href=vara/{$row['VaruID']}>".$row['Namn'] . "<br> ". $row['Antal'] ."</a>";


    }

    $conn->close();
    ?>
</div>


</body>