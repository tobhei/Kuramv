<?php
include "helpers/header.php";
include "inkludering/funk.ink.php";
?>
<?php
if($_SESSION['admin'] == true){
header('location: login.php');
}
?>
<!DOCTYPE html>
<?php include "inkludering/funk.ink.php"?>
<section>
    <link rel="stylesheet" href="style.css">
    <div class="navbar">
    <?php
    if ($_SESSION["useruid"]===1) {
    echo "<a href='index.php'> Hem </a> ";
    echo "<a href='inkludering/logout.ink.php'> logga ut </a> ";
    echo "<a>Välkommen tillbaka " . $_SESSION["useruid"] ."</a>";
    } else {
    echo "<a href='login.php'> Logga in</a> ";
    }
    ?>
    </div>
        <?php
        include "inkludering/dbpek.ink.php";
        $records = mysqli_query($conn,"SELECT * FROM users");
        while($data = mysqli_fetch_array($records)) {
          ?>
          <div class="signupform">
          <tr>
              <?php echo $data['userId']; ?>
              <?php echo $data['usersFname']; ?>
              <?php echo $data['usersEname']; ?>
              <?php echo $data['usersEmail']; ?>      
              <a href="inkludering/adminpage.ink.php?userId=<?php echo $data['userId']; ?>">Ändra</a>
          </tr>   
            </div>	
          <?php
          }
          ?>

        </div>
        <?php
        if (isset($_GET["error"])) {
           if ($_GET["error"] == "stmtfailed") {
              echo "<p>Hoppsan någt gick fel</p>";
            } else if ($_GET["error"] == "emailtaken") {
              echo "<p>E-mailen finns redan</p>";  
            }
          }
        ?>
</section>
