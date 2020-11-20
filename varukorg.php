<!DOCTYPE html>
<html lang="en">
<!--Scroll function by https://www.w3schools.com/howto/howto_css_menu_horizontal_scroll.asp-->
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>Varukorg</title>

    <style >
        .title{
            font-size: 32px;
            display: grid;
            text-align: center;
        }
        div.grid-item{
            padding: 20px;
            font-size: 20px;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.8);
            display: grid;
            grid-template-columns: auto auto;
        }

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

        .left-alligned{
            font-size: 32px;
            display: grid;
            text-align: left;
        }
        .right-alligned{
            font-size: 32px;
            display: grid;
            text-align: right;
        }
    </style>
</head>
<body>
<a class="title">Varukorg</a>
<div class="scrollmenu">
   <!-- <a href="#home">Home</a>-->

    <?php
    $kundnummer = "2";
    $totpris = 0;
    $totsaker = 0;
    $conn = include 'setup.php';
    //$stmt = $conn->prepare("SELECT * FROM {$dbname}.varukorg WHERE kundnummer=?");
    //SELECT vk.VaruID, vk.Antal, v.Namn FROM (D0018ELABB.varukorg vk inner join D0018ELABB.Varor v on vk.VaruID = v.VaruID)
    $stmt = $conn->prepare("SELECT vk.VaruID, vk.Antal, v.Namn,v.ResourceURL,v.Pris 
        FROM (({$dbname}.varukorg vk)
        inner join {$dbname}.Varor v on vk.VaruID = v.VaruID) where `kundnummer` = ?");

    if ( $stmt===false ) {
        $conn->close();
        die('prepare() failed: ' . htmlspecialchars($conn->error));

    }

    $stmt->bind_param("i", $kundnummer);
    $stmt->execute();

    $res = $stmt->get_result();
    $conn->close();

    while(($row = $res->fetch_assoc()) != false){
        $totpris += $row['Pris']*$row['Antal'];
        $totsaker += $row['Antal'];
        echo "<div class='grid-item'>
                    <div class='left-alligned'>
                        <img src='{$row['ResourceURL']}'>
                    </div>
                    <div class='right-alligned'>
                        <a href=vara/{$row['VaruID']}>".$row['Namn'] . "</a><a>
                        ". $row['Antal'] ."<br>
                         ". $row['Pris'] ."</a> 
                    </div>
               </div>";


    }
    echo"<a>Antal Varor:{$totsaker}</a>
         <a>Totalt pris:{$totpris}</a>";



    ?>





</div>


</body>