<?php include "helpers/header.php"?>

<!DOCTYPE html>
<?php include "inkludering/funk.ink.php"?>
<section>
    <link rel="stylesheet" href="style.css">
    <div class="navbar">
    <?php
    if (isset($_SESSION["useruid"])) {
    echo "<a href='index.php'> Hem </a> ";
    echo "<a href='inkludering/logout.ink.php'> logga ut </a> ";
    echo "<a>Välkommen tillbaka " . $_SESSION["useruid"] ."</a>";
    } else {
    echo "<a href='login.php'> Logga in</a> ";
    }
    ?>
    </div>
        <div class="signupform">
        <?php
        include "setup.php";
        $records = $conn->query("SELECT * FROM users Where userId = ".$_SESSION["userid"]);
        while($data = $records->fetch_row()) {
          ?>
          <div class="signupform">
          <tr>
              <a> Profilbild <br> <img src="<?php echo $data[8];?>" width="400" height="300 " alt="" alt=""> </a> 
              <a> Förnamn: <?php echo $data[1]; ?> <br> </a>
              <a> Efternamn: <?php echo $data[2]; ?> <br> </a>
              <a> Email: <?php echo $data[3]; ?> <br></a>
              <a> Medlem sedan: <?php echo $data[6]; ?> <br></a>
              <a href="inkludering/profilsida.ink.php?userId=<?php echo $data[0]; ?>">Ändra</a>
              <a href="ordersida.php">Se Ordrar</a>
              
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