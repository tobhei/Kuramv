<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>

    <style>
        .headerBox{
            border: solid black;
            display: grid;
            grid-template-columns: auto auto;
        }
        .headerTitle{
            alignment: left;
        }
        .headerLogin{
            alignment: right;
        }
    </style>
</head>
<body>

<div class="headerBox">
    <img class="headerTitle" src="helpers/title.png">

    <div class="headerLogin">
        <?php


        $_SESSION['userid'] = 1;
        if(isset($_SESSION['userid'])){

            $stmta = $conn->prepare("SELECT profilePic FROM {$dbname}.users WHERE userID = ?");


            $stmta->bind_param("s",$_SESSION['userid']);
            $stmta->execute();
            $result = $stmta->get_result();

            echo "<img class='headerLogin' src= '". $result->fetch_row()[0]. "'>";

            //<img class="headerLogin" src="../res/a.png">
        }
        ?>
    </div>

</div>



</body>
</html>