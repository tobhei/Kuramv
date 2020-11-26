<?php
    include_once 'header.php'; 
?> 
<!DOCTYPE html>
<section>
    <link rel="stylesheet" href="style.css">
    <div class="navbar">
    <?php
    if (isset($_SESSION["useruid"])) {
    echo "<a href='index.php'> Hem </a> ";
    echo "<a href='inkludering/logout.ink.php'> logga ut </a> ";
    echo "<a>Välkommen tillbaka " . $_SESSION["useruid"] . "</a>";
    } else {
    echo "<a href='login.php'> Logga in</a> ";
    }
    ?>
    </div>
        <div class="signupform">
        <h1>Ändra uppgifter</h1>
        <form action="inkludering/profilsida.ink.php" method="post">
            <input class="inputbox" type="text" name="fnamn" placeholder="Ändra förnamn">
            <input class="inputbox" type="text" name="enamn" placeholder="Ändra efternamn">
            <input class="inputbox" type="email" name="email" placeholder="Ändra e-mailadress">
            <input class="inputbox" type="password" name="pwd" placeholder="Byt lösenord">
            <input class="inputbox" type="password" name="pwdrepeat" placeholder="upprepa lösenord">
            <button class="signupknapp" type="submit" name="submit">Byt uppgifter</button>
        </form>
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