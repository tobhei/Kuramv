<?php session_start(); ?>
<!DOCTYPE html>
<section>
    <link rel="stylesheet" href="style.css">
    <div class="navbar">
    <?php
    if (isset($_SESSION["userid"])) {
    echo "<a href='index.php'> Hem </a> ";
    echo "<a href='helpers/logout.ink.php'> logga ut </a> ";
    echo "<a>Välkommen tillbaka " . $_SESSION["userid"] . "</a>";
    } else {
    echo "<a href='login.php'> Logga in</a> ";
    }
    ?>
    </div>
        <div class="signupform">
        <?php
        include "helpers/dbpek.ink.php";
        $records = $conn->query("SELECT * FROM users Where userId = ".$_SESSION["userid"]);
        while($data = $records->fetch_row()) {
          ?>
          <div class="signupform">
          <tr>
              <?php echo $data[0]; ?>
              <?php echo $data[1]; ?>
              <?php echo $data[2]; ?>
              <?php echo $data[3]; ?>
              <?php echo $data[8]; ?> 
              <img src="<?php echo $data[8];?>" alt="">  
              <a href="helpers/profilsida.ink.php?userId=<?php echo $data[0]; ?>">Ändra</a>
          </tr>   
            </div>	
          <?php
          }
          ?>
        </div>
      
        
        <?php
        if (isset($_GET["error"])) {
              if ($_GET["error"] == "passwordsdontmatch") {
              echo "<p>Lösenorden överensstämmer inte</p>";
            } else if ($_GET["error"] == "stmtfailed") {
              echo "<p>Hoppsan någt gick fel</p>";
            } else if ($_GET["error"] == "emailtaken") {
              echo "<p>E-mailen finns redan</p>";  
            }
          }
        ?>   
</section>