<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>
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
            background: white;
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
    <script>
        function clicked() {
            window.location.href = '/varuregister.php';
        }
    </script>
    <img class="headerTitle" src="helpers/title.png" onclick="clicked()">

    <div class="headerLogin">
        <?php
        $conn = include ("setup.php");

        //$_SESSION['userid'] = 1;
        if(isset($_SESSION['userid'])){

            $stmta = $conn->prepare("SELECT profilePic FROM {$dbname}.users WHERE userID = ?");


            $stmta->bind_param("s",$_SESSION['userid']);
            $stmta->execute();
            $result = $stmta->get_result();
            $pic = $result->fetch_row()[0];
            if($pic == null){
                echo "<a href='/profilsida.php'>Profil Sida</a>";
            }else{
                echo "<img id='icon' onclick='click()' class='headerLogin' src= '". $pic. "'>";
            }

            echo "<script>
            function click(){
                window.location.href = '/profilsida.php';
            }</script>";

            //<img class="headerLogin" src="../res/a.png">
        }else{
            echo "<a href='/login.php'>Logga in</a>";
            echo "<script>
            function click(){
                window.location.href = '/login.php';
            }</script>";
        }
        ?>

    </div>

</div>



</body>
</html>